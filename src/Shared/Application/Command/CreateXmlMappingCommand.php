<?php

namespace App\Shared\Application\Command;

use App\Shared\Utils;
use DOMDocument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Completion\CompletionInput;
use Symfony\Component\Console\Completion\CompletionSuggestions;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use SimpleXMLElement;

#[AsCommand(name: 'app:generate-xml-mapping', description: 'Generates Doctrine XML mapping for a table.')]
class CreateXmlMappingCommand extends Command
{
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
        $tableName = $helper->ask($input, $output, $question);

        if($this->checkIfMappingExist($domain, $tableName)){
            $io->error("Table '$tableName' already exists!!!");

            return Command::FAILURE;
        };

        $xml = new SimpleXMLElement('<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd"></doctrine-mapping>');
        $entity = $xml->addChild('entity');
        $entity->addAttribute('name', $tableName);
        $entity->addAttribute('table', $tableName);

        while (true) {
            $columnName = $helper->ask($input, $output, new Question('Enter column name (or leave empty to finish): '));
            if (empty($columnName)) {
                break;
            }

            $question = new Question('Enter column type: ');
            $question->setAutocompleterValues(['string', 'integer', 'decimal', 'datetime']);

            $type = $helper->ask($input, $output, $question);
            $field = $entity->addChild('field');
            $field->addAttribute('name', $columnName);
            $field->addAttribute('type', $type);
            $field->addAttribute('column', Utils::toSnakeCase($columnName));

            // Tutaj można dodać więcej pytań dotyczących atrybutów kolumny, np. długość, nullable itp.
        }

        $xmlString = $xml->asXML();

        $doc = new DOMDocument();

        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;

        $doc->loadXML($xmlString);

        $string = $doc->saveXML();


        file_put_contents('./src/'.$domain.'/Infrastructure/DoctrineMappings/'.$tableName.'.orm.xml', $string);
        // Zapisz $xmlString do pliku, np. do config/doctrine/{TableName}.orm.xml

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
}