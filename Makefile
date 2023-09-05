include .env
up:
	docker create web
	docker-compose up -d --build
updateDependencies:
	docker exec -i ${COMPOSE_PROJECT_NAME}-app-1 composer install
	docker exec -i ${COMPOSE_PROJECT_NAME}-app-1 php artisan migrate
	docker exec -i ${COMPOSE_PROJECT_NAME}-app-1 php artisan db:seed --class=UserTransactionSeeder
	docker exec -i ${COMPOSE_PROJECT_NAME}-app-1 php artisan make:command WithdrawFunds
	docker exec -i ${COMPOSE_PROJECT_NAME}-app-1 php artisan make:command DepositFunds
	docker exec -i ${COMPOSE_PROJECT_NAME}-app-1 php artisan make:command ShowTransactions

.PHONY: app
app:
	docker exec -it ${COMPOSE_PROJECT_NAME}-app-1 bash
deposit:
	@read -p "Enter user ID: " user_id; \
    read -p "Enter amount: " amount; \
	docker exec -i ${COMPOSE_PROJECT_NAME}-app-1 php artisan balance:deposit $$user_id $$amount
withdraw:
	@read -p "Enter user ID: " user_id; \
    read -p "Enter amount: " amount; \
	docker exec -i ${COMPOSE_PROJECT_NAME}-app-1 php artisan balance:withdraw $$user_id $$amount
showTransactions:
	@read -p "Enter user ID: " user_id; \
	docker exec -i ${COMPOSE_PROJECT_NAME}-app-1 php artisan transactions:show $$user_id
