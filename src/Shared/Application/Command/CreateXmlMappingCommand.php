<?php

namespace App\Shared\Application\Command;

use App\Shared\Utils;
use DOMDocument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use SimpleXMLElement;

#[AsCommand(name: 'app:generate-xml-mapping', description: 'Generates Doctrine XML mapping for a table.')]
class CreateXmlMappingCommand extends Command
{
    private SimpleXMLElement $xml;
    private string $entityContent;
    private string $repositoryContent;
    private string $repositoryPortContent;
    public function __construct(?string $name = null)
    {
        $this->xml = new SimpleXMLElement('<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd"></doctrine-mapping>');
        $this->entityContent = "<?php \n\n";
        $this->repositoryContent = "<?php \n\n";
        $this->repositoryPortContent = "<?php \n\n";

        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setHelp('This command allows you to generate a Doctrine XML mapping file for your database table.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        $domains = $this->getAvailableDomains();

        $question = new ChoiceQuestion('Please enter the name of the Domain: ', $domains, 0);
        $domain = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the name of the table: ');
        $tableName = ucwords($helper->ask($input, $output, $question));


        if($this->checkIfMappingExist($domain, $tableName)){
            $io->error("Table '$tableName' already exists!!!");

            return Command::FAILURE;
        };

        $entityPath = "App\\$domain\\Domain\\Entity\\$tableName";
        $this->entityContent .= "namespace App\\$domain\\Domain\\Entity; \n";
        $this->entityContent .= "class $tableName\n{\n}";

        $repositoryPath = "App\\$domain\\Infrastructure\\Repository\\$tableName"."Repository";

        $question = new ChoiceQuestion('Choose type of mapping ', ['entity','embeddable'], 0);
        $typeOfMapping = $helper->ask($input, $output, $question);


        if ($typeOfMapping === 'embeddable'){
            $object = $this->xml->addChild('embeddable');
            $object->addAttribute('name', $entityPath);

        } else {
            $this->generateRepositoryFile($tableName, $domain);
            $this->generateRepositoryPortFile($tableName, $domain);

            $object = $this->xml->addChild('entity');
            $object->addAttribute('name', $entityPath);
            $object->addAttribute('table', $tableName);
            $object->addAttribute('repository-class', $repositoryPath);

            $id = $object->addChild('id');
            $id->addAttribute('name','id');
            $id->addAttribute('type','guid');
            $id->addAttribute('column','id');
        }

        while (true) {
            $columnName = $helper->ask($input, $output, new Question('Enter column name (or leave empty to finish): '));
            if (empty($columnName)) {
                break;
            }

            $question = new Question('Enter column type: ');
            $question->setAutocompleterValues(['string', 'integer', 'decimal', 'datetime', 'embedded']);
            $type = $helper->ask($input, $output, $question);

             if ($type === 'embedded'){
                $embedded = $object->addChild('embedded');
                $embedded->addAttribute('name', $columnName);

                $question = new Question('Enter VO name: ');
                $voName = $helper->ask($input, $output, $question);

                $embedded->addAttribute('class', "App\\$domain\\Domain\\Entity\\$voName");
                $embedded->addAttribute('use-column-prefix', 'false');
            } else {
                $field = $object->addChild('field');

                if ($typeOfMapping === 'embeddable'){
                    $question = new Question('Value name in VO: ');
                    $name = $helper->ask($input, $output, $question);
                    $field->addAttribute('name', $name);
                } else {
                    $field->addAttribute('name', $columnName);
                }

                $field->addAttribute('type', $type);
                $field->addAttribute('column', Utils::toSnakeCase($columnName));
            }

        }

        $xmlString = $this->xml->asXML();

        $doc = new DOMDocument();

        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;

        $doc->loadXML($xmlString);

        $xmlString = $doc->saveXML();


        file_put_contents("./src/$domain/Infrastructure/DoctrineMappings/$tableName.orm.xml", $xmlString);
        file_put_contents("./src/$domain/Domain/Entity/$tableName.php", $this->entityContent);

        if($typeOfMapping === 'entity'){
            file_put_contents("./src/$domain/Infrastructure/Repository/$tableName"."Repository.php", $this->repositoryContent);
            file_put_contents("./src/$domain/Domain/RepositoryPort/$tableName"."RepositoryInterface.php", $this->repositoryPortContent);
        }


        $io->success("XML mapping for table '$tableName' has been successfully generated.");

        return Command::SUCCESS;
    }

    private function getAvailableDomains(): array{
        $domains = [];

        foreach (scandir('./src') as $dir){
            $explode = explode('.', $dir);

            if(!in_array($explode[0], ["","Kernel","Shared"]) ){
                $domains[] = $explode[0];
            }
        }

        return $domains;
    }

    private function checkIfMappingExist(string $domain, string $tableName): bool{
        foreach(scandir('./src/'.$domain.'/Infrastructure/DoctrineMappings') as $dir){
            $explode = explode('.', $dir);

            if($explode[0] === $tableName ){
                return true;
            }
        };

        return false;
    }

    private function generateRepositoryFile(string $tableName, string $domain): void
    {
        $this->repositoryContent .= "namespace App\\$domain\\Infrastructure\\Repository; \n";
        $this->repositoryContent .= '
use App\\'.$domain.'\Domain\Entity\\'.$tableName.';
use App\\'.$domain.'\Domain\RepositoryPort\\'.$tableName.'RepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Board>
 *
 * @method '.$tableName.'|null find($id, $lockMode = null, $lockVersion = null)
 * @method '.$tableName.'|null findOneBy(array $criteria, array $orderBy = null)
 * @method '.$tableName.'[]    findAll()
 * @method '.$tableName.'[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class '.$tableName.'Repository extends ServiceEntityRepository implements '.$tableName.'RepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, '.$tableName.'::class);
    }

    public function save('.$tableName.' $'.Utils::toCamelCase($tableName).'): void
    {
        $em = $this->getEntityManager();
        $em->persist($'.Utils::toCamelCase($tableName).');
        $em->flush();
    }
}
';
    }
    private function generateRepositoryPortFile(string $tableName, string $domain): void{
        $this->repositoryPortContent .= "namespace App\\$domain\\Domain\\RepositoryPort; \n";
        $this->repositoryPortContent .= '
use App\\'.$domain.'\Domain\Entity\\'.$tableName.';

interface '.$tableName.'RepositoryInterface
{
    public function findOneBy(array $criteria, array $orderBy = null);

    public function save('.$tableName.' $'.Utils::toCamelCase($tableName).'): void;
}';

    }
}