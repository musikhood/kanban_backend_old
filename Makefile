board_entity:
	@test $(name)
	php bin/console make:entity '\App\Board\Domain\Entity\$(name)'

user_entity:
	@test $(name)
	php bin/console make:user '\App\User\Domain\Entity\$(name)'