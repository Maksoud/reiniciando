<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    public function up()
    {

        $this->table('account_plans')
            ->addColumn('created', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('order', 'string', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('classification', 'string', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('group', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('plangroup', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('receitadespesa', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->create();

        $this->table('balances')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('banks_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('boxes_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('cards_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('plannings_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('date', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('value', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->create();

        $this->table('banks')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('banco', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('agencia', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('conta', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('tipoconta', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('numbanco', 'string', [
                'default' => null,
                'limit' => 5,
                'null' => false,
            ])
            ->addColumn('emitecheque', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->create();

        $this->table('boxes')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->create();

        $this->table('cards')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('providers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('costs_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('vencimento', 'integer', [
                'default' => null,
                'limit' => 2,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('bandeira', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('melhor_dia', 'integer', [
                'default' => null,
                'limit' => 2,
                'null' => false,
            ])
            ->addColumn('limite', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'providers_id',
                ]
            )
            ->addIndex(
                [
                    'costs_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'providers_id',
                ]
            )
            ->addIndex(
                [
                    'costs_id',
                ]
            )
            ->create();

        $this->table('coins')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('simbolo', 'string', [
                'default' => null,
                'limit' => 5,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->create();

        $this->table('costs')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->create();

        $this->table('customers')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('tipo', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('fantasia', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('cpfcnpj', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('ie', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('banco', 'string', [
                'default' => null,
                'limit' => 25,
                'null' => true,
            ])
            ->addColumn('agencia', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('conta', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('endereco', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('referencia', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('bairro', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('cep', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('cidade', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('estado', 'string', [
                'default' => null,
                'limit' => 2,
                'null' => false,
            ])
            ->addColumn('telefone1', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('telefone2', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('telefone3', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('telefone4', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('obs', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->create();

        $this->table('document_types')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('vinculapgto', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('duplicadoc', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->create();

        $this->table('event_types')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->create();

        $this->table('knowledges')
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('title', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('moviment_banks')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('ordem', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('banks_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('costs_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('document_types_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('event_types_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('moviment_checks_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('transfers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('moviments_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('providers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('customers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('account_plans_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('coins_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('creditodebito', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('data', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('vencimento', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('dtbaixa', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('valor', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('valorbaixa', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('documento', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addColumn('historico', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('contabil', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('obs', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'banks_id',
                ]
            )
            ->addIndex(
                [
                    'costs_id',
                ]
            )
            ->addIndex(
                [
                    'document_types_id',
                ]
            )
            ->addIndex(
                [
                    'event_types_id',
                ]
            )
            ->addIndex(
                [
                    'moviment_checks_id',
                ]
            )
            ->addIndex(
                [
                    'transfers_id',
                ]
            )
            ->addIndex(
                [
                    'moviments_id',
                ]
            )
            ->addIndex(
                [
                    'providers_id',
                ]
            )
            ->addIndex(
                [
                    'customers_id',
                ]
            )
            ->addIndex(
                [
                    'account_plans_id',
                ]
            )
            ->addIndex(
                [
                    'coins_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'banks_id',
                ]
            )
            ->addIndex(
                [
                    'costs_id',
                ]
            )
            ->addIndex(
                [
                    'document_types_id',
                ]
            )
            ->addIndex(
                [
                    'event_types_id',
                ]
            )
            ->addIndex(
                [
                    'moviment_checks_id',
                ]
            )
            ->addIndex(
                [
                    'transfers_id',
                ]
            )
            ->addIndex(
                [
                    'moviments_id',
                ]
            )
            ->addIndex(
                [
                    'providers_id',
                ]
            )
            ->addIndex(
                [
                    'customers_id',
                ]
            )
            ->addIndex(
                [
                    'account_plans_id',
                ]
            )
            ->addIndex(
                [
                    'coins_id',
                ]
            )
            ->create();

        $this->table('moviment_boxes')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('ordem', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('boxes_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('costs_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('document_types_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('event_types_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('moviment_checks_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('transfers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('moviments_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('account_plans_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('coins_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('customers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('providers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('creditodebito', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('data', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('vencimento', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('dtbaixa', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('valor', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('valorbaixa', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('documento', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addColumn('historico', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('contabil', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('obs', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'boxes_id',
                ]
            )
            ->addIndex(
                [
                    'costs_id',
                ]
            )
            ->addIndex(
                [
                    'document_types_id',
                ]
            )
            ->addIndex(
                [
                    'event_types_id',
                ]
            )
            ->addIndex(
                [
                    'moviment_checks_id',
                ]
            )
            ->addIndex(
                [
                    'transfers_id',
                ]
            )
            ->addIndex(
                [
                    'moviments_id',
                ]
            )
            ->addIndex(
                [
                    'providers_id',
                ]
            )
            ->addIndex(
                [
                    'customers_id',
                ]
            )
            ->addIndex(
                [
                    'account_plans_id',
                ]
            )
            ->addIndex(
                [
                    'coins_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'boxes_id',
                ]
            )
            ->addIndex(
                [
                    'costs_id',
                ]
            )
            ->addIndex(
                [
                    'document_types_id',
                ]
            )
            ->addIndex(
                [
                    'event_types_id',
                ]
            )
            ->addIndex(
                [
                    'moviment_checks_id',
                ]
            )
            ->addIndex(
                [
                    'transfers_id',
                ]
            )
            ->addIndex(
                [
                    'moviments_id',
                ]
            )
            ->addIndex(
                [
                    'providers_id',
                ]
            )
            ->addIndex(
                [
                    'customers_id',
                ]
            )
            ->addIndex(
                [
                    'account_plans_id',
                ]
            )
            ->addIndex(
                [
                    'coins_id',
                ]
            )
            ->create();

        $this->table('moviment_cards')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('ordem', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('cards_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('moviments_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('banks_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('boxes_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('document_types_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('event_types_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('account_plans_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('costs_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('coins_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('customers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('providers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('vencimento', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('documento', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addColumn('creditodebito', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('valor', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('valorbaixa', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('data', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('dtbaixa', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('contabil', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('obs', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'cards_id',
                ]
            )
            ->addIndex(
                [
                    'banks_id',
                ]
            )
            ->addIndex(
                [
                    'boxes_id',
                ]
            )
            ->addIndex(
                [
                    'costs_id',
                ]
            )
            ->addIndex(
                [
                    'document_types_id',
                ]
            )
            ->addIndex(
                [
                    'event_types_id',
                ]
            )
            ->addIndex(
                [
                    'moviments_id',
                ]
            )
            ->addIndex(
                [
                    'account_plans_id',
                ]
            )
            ->addIndex(
                [
                    'coins_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'cards_id',
                ]
            )
            ->addIndex(
                [
                    'banks_id',
                ]
            )
            ->addIndex(
                [
                    'boxes_id',
                ]
            )
            ->addIndex(
                [
                    'costs_id',
                ]
            )
            ->addIndex(
                [
                    'document_types_id',
                ]
            )
            ->addIndex(
                [
                    'event_types_id',
                ]
            )
            ->addIndex(
                [
                    'moviments_id',
                ]
            )
            ->addIndex(
                [
                    'account_plans_id',
                ]
            )
            ->addIndex(
                [
                    'coins_id',
                ]
            )
            ->create();

        $this->table('moviment_checks')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('ordem', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('banks_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('boxes_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('costs_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('event_types_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('providers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('account_plans_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('moviments_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('transfers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('coins_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('caixaforn', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('cheque', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('nominal', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('data', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('valor', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('documento', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addColumn('historico', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('contabil', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('obs', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'banks_id',
                ]
            )
            ->addIndex(
                [
                    'boxes_id',
                ]
            )
            ->addIndex(
                [
                    'costs_id',
                ]
            )
            ->addIndex(
                [
                    'event_types_id',
                ]
            )
            ->addIndex(
                [
                    'transfers_id',
                ]
            )
            ->addIndex(
                [
                    'moviments_id',
                ]
            )
            ->addIndex(
                [
                    'providers_id',
                ]
            )
            ->addIndex(
                [
                    'account_plans_id',
                ]
            )
            ->addIndex(
                [
                    'coins_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'banks_id',
                ]
            )
            ->addIndex(
                [
                    'boxes_id',
                ]
            )
            ->addIndex(
                [
                    'costs_id',
                ]
            )
            ->addIndex(
                [
                    'event_types_id',
                ]
            )
            ->addIndex(
                [
                    'transfers_id',
                ]
            )
            ->addIndex(
                [
                    'moviments_id',
                ]
            )
            ->addIndex(
                [
                    'providers_id',
                ]
            )
            ->addIndex(
                [
                    'account_plans_id',
                ]
            )
            ->addIndex(
                [
                    'coins_id',
                ]
            )
            ->create();

        $this->table('moviment_mergeds')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('moviments_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('moviments_merged', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'moviments_id',
                ]
            )
            ->addIndex(
                [
                    'moviments_merged',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'moviments_id',
                ]
            )
            ->addIndex(
                [
                    'moviments_merged',
                ]
            )
            ->create();

        $this->table('moviment_recurrents')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('moviments_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('moviment_cards_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'moviments_id',
                ]
            )
            ->addIndex(
                [
                    'moviment_cards_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'moviments_id',
                ]
            )
            ->addIndex(
                [
                    'moviment_cards_id',
                ]
            )
            ->create();

        $this->table('moviments')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('ordem', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('banks_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('boxes_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('cards_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('plannings_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('costs_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('event_types_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('providers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('customers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('document_types_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('account_plans_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('coins_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('documento', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('cheque', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('nominal', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('emissaoch', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('creditodebito', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('data', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('vencimento', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('dtbaixa', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('valor', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('valorbaixa', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('historico', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('contabil', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('userbaixa', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('obs', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'banks_id',
                ]
            )
            ->addIndex(
                [
                    'boxes_id',
                ]
            )
            ->addIndex(
                [
                    'cards_id',
                ]
            )
            ->addIndex(
                [
                    'plannings_id',
                ]
            )
            ->addIndex(
                [
                    'costs_id',
                ]
            )
            ->addIndex(
                [
                    'event_types_id',
                ]
            )
            ->addIndex(
                [
                    'providers_id',
                ]
            )
            ->addIndex(
                [
                    'customers_id',
                ]
            )
            ->addIndex(
                [
                    'document_types_id',
                ]
            )
            ->addIndex(
                [
                    'account_plans_id',
                ]
            )
            ->addIndex(
                [
                    'coins_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'banks_id',
                ]
            )
            ->addIndex(
                [
                    'boxes_id',
                ]
            )
            ->addIndex(
                [
                    'cards_id',
                ]
            )
            ->addIndex(
                [
                    'plannings_id',
                ]
            )
            ->addIndex(
                [
                    'costs_id',
                ]
            )
            ->addIndex(
                [
                    'event_types_id',
                ]
            )
            ->addIndex(
                [
                    'providers_id',
                ]
            )
            ->addIndex(
                [
                    'customers_id',
                ]
            )
            ->addIndex(
                [
                    'document_types_id',
                ]
            )
            ->addIndex(
                [
                    'account_plans_id',
                ]
            )
            ->addIndex(
                [
                    'coins_id',
                ]
            )
            ->create();

        $this->table('moviments_moviment_cards')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('cards_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('moviments_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('vencimento', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'cards_id',
                ]
            )
            ->addIndex(
                [
                    'moviments_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'cards_id',
                ]
            )
            ->addIndex(
                [
                    'moviments_id',
                ]
            )
            ->create();

        $this->table('parameters')
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('razao', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addColumn('ie', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('cpfcnpj', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('tipo', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('email_cobranca', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('endereco', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('bairro', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('cidade', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('estado', 'string', [
                'default' => null,
                'limit' => 2,
                'null' => true,
            ])
            ->addColumn('cep', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('telefone', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('fundacao', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('logomarca', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('dtvalidade', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('plano', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('mensalidade', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('periodo_ativacao', 'integer', [
                'default' => null,
                'limit' => 2,
                'null' => false,
            ])
            ->addColumn('mf_coins_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mf_document_types_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mf_carriers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mf_event_types_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mf_contabil', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('mf_costs_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mf_account_plans_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mc_coins_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mc_creditodebito', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('mc_contabil', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('mc_event_boxes_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mc_costs_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mc_account_plans_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mb_coins_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mb_creditodebito', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('mb_contabil', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('mb_event_banks_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mb_event_types_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mb_costs_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mb_account_plans_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mt_coins_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mt_contabil', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('mt_event_types_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mt_costs_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mt_account_plans_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mh_coins_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mh_event_banks_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mh_event_boxes_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mh_event_types_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mh_contabil', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('mh_costs_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('mh_account_plans_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->create();

        $this->table('payments')
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('vencimento', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('periodo', 'integer', [
                'default' => null,
                'limit' => 2,
                'null' => false,
            ])
            ->addColumn('valor', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->create();

        $this->table('plannings')
            ->addColumn('ordem', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('providers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('coins_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('data', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('valor', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('parcelas', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('obs', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'providers_id',
                ]
            )
            ->addIndex(
                [
                    'coins_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'providers_id',
                ]
            )
            ->addIndex(
                [
                    'coins_id',
                ]
            )
            ->create();

        $this->table('providers')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('tipo', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('fantasia', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('ie', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('cpfcnpj', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('endereco', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('bairro', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('cidade', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('estado', 'string', [
                'default' => null,
                'limit' => 2,
                'null' => false,
            ])
            ->addColumn('cep', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('telefone1', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('telefone2', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('telefone3', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('telefone4', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addColumn('banco', 'string', [
                'default' => null,
                'limit' => 25,
                'null' => true,
            ])
            ->addColumn('agencia', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('conta', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('obs', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->create();

        $this->table('regs')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('users_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('log_type', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('function', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('table', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('content', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'users_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'users_id',
                ]
            )
            ->create();

        $this->table('rules')
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('rule', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->create();

        $this->table('stk_groupings')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('order', 'string', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('group', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->create();

        $this->table('stk_localizations')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('obs', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('stk_product_compositions')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('stk_product_compositions_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('stk_products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('quantidade', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('unidade', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->create();

        $this->table('stk_products')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('ordem', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('codbarras', 'string', [
                'default' => null,
                'limit' => 13,
                'null' => true,
            ])
            ->addColumn('ncm', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('compositions', 'string', [
                'default' => '0',
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('obs', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('stk_groupings_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->create();

        $this->table('stk_purchase_items')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('stk_purchases_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('stk_products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('quantidade', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('unidade', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('icms', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('icmssub', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('ipi', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('cfop', 'integer', [
                'default' => null,
                'limit' => 4,
                'null' => false,
            ])
            ->addColumn('vlrunit', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('vlrdesconto', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('vlrtotal', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->create();

        $this->table('stk_purchases')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('stk_products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('transporters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('providers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('data', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('ordem_fabricacao', 'string', [
                'default' => null,
                'limit' => 12,
                'null' => true,
            ])
            ->addColumn('quantidade', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('cfop', 'string', [
                'default' => null,
                'limit' => 12,
                'null' => true,
            ])
            ->addColumn('vlrunit', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('vlripi', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('vlricms', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('vlricmssubst', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('vlrfrete', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('vlrdesconto', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('vlrtotal', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('unidade', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('obs', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('stk_requisition_items')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('stk_requisitions_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('stk_products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('quantidade', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('unidade', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->create();

        $this->table('stk_requisitions')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('ordem', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('data', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('ordem_fabricacao', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('vlrunit', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('vlrtotal', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('requerente', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addColumn('autorizador', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addColumn('dtautorizacao', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('obs', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('stk_sell_items')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('stk_sells_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('stk_products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('quantidade', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('unidade', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('icms', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('icmssub', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('ipi', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('cfop', 'integer', [
                'default' => null,
                'limit' => 4,
                'null' => false,
            ])
            ->addColumn('vlrunit', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('vlrdesconto', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('vlrtotal', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->create();

        $this->table('stk_sellers')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('comissao', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('obs', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('stk_sells')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('stk_products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('customers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('transporters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('data', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('ordem_fabricacao', 'string', [
                'default' => null,
                'limit' => 12,
                'null' => true,
            ])
            ->addColumn('quantidade', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('cfop', 'string', [
                'default' => null,
                'limit' => 12,
                'null' => true,
            ])
            ->addColumn('vlrunit', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('vlripi', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('vlricms', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('vlricmssubst', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('vlrfrete', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('vlrdesconto', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('vlrtotal', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('unidade', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('obs', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('stk_stocks')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('stk_products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('stk_localizations_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('quantidade', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('minimo', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('unidade', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('data', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('support_contacts')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('numero_caso', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('descricao', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('resposta', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->create();

        $this->table('transfers')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('ordem', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('banks_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('boxes_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('costs_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('coins_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('account_plans_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('document_types_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('event_types_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('banks_dest', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('boxes_dest', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('costs_dest', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('account_plans_dest', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('data', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('programacao', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('radio_origem', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('radio_destino', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('valor', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('documento', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addColumn('historico', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('emissaoch', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('cheque', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('nominal', 'string', [
                'default' => null,
                'limit' => 120,
                'null' => true,
            ])
            ->addColumn('contabil', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('obs', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'banks_id',
                ]
            )
            ->addIndex(
                [
                    'boxes_id',
                ]
            )
            ->addIndex(
                [
                    'costs_id',
                ]
            )
            ->addIndex(
                [
                    'coins_id',
                ]
            )
            ->addIndex(
                [
                    'account_plans_id',
                ]
            )
            ->addIndex(
                [
                    'document_types_id',
                ]
            )
            ->addIndex(
                [
                    'event_types_id',
                ]
            )
            ->addIndex(
                [
                    'banks_dest',
                ]
            )
            ->addIndex(
                [
                    'boxes_dest',
                ]
            )
            ->addIndex(
                [
                    'costs_dest',
                ]
            )
            ->addIndex(
                [
                    'account_plans_dest',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'banks_id',
                ]
            )
            ->addIndex(
                [
                    'boxes_id',
                ]
            )
            ->addIndex(
                [
                    'costs_id',
                ]
            )
            ->addIndex(
                [
                    'coins_id',
                ]
            )
            ->addIndex(
                [
                    'account_plans_id',
                ]
            )
            ->addIndex(
                [
                    'document_types_id',
                ]
            )
            ->addIndex(
                [
                    'event_types_id',
                ]
            )
            ->addIndex(
                [
                    'banks_dest',
                ]
            )
            ->addIndex(
                [
                    'boxes_dest',
                ]
            )
            ->addIndex(
                [
                    'costs_dest',
                ]
            )
            ->addIndex(
                [
                    'account_plans_dest',
                ]
            )
            ->create();

        $this->table('transporters')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('tipo', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('fantasia', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('ie', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('cpfcnpj', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('dtnascimento', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('contato', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('endereco', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('bairro', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('cidade', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('estado', 'string', [
                'default' => null,
                'limit' => 2,
                'null' => false,
            ])
            ->addColumn('cep', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('telefone1', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('telefone2', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('telefone3', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('telefone4', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addColumn('representante', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('banco', 'string', [
                'default' => null,
                'limit' => 25,
                'null' => true,
            ])
            ->addColumn('agencia', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('conta', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('obs', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addIndex(
                [
                    'cpfcnpj',
                    'parameters_id',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->create();

        $this->table('users')
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 80,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 80,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('sendmail', 'string', [
                'default' => '0',
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('redefinir_senha', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('tutorial', 'string', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->create();

        $this->table('users_parameters')
            ->addColumn('parameters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('users_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('rules_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(
                [
                    'users_id',
                ]
            )
            ->addIndex(
                [
                    'rules_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->addIndex(
                [
                    'users_id',
                ]
            )
            ->addIndex(
                [
                    'rules_id',
                ]
            )
            ->addIndex(
                [
                    'parameters_id',
                ]
            )
            ->create();

        $this->table('versions', ['id' => false, 'primary_key' => ['']])
            ->addColumn('financeiro', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('estoque', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->create();
    }

    public function down()
    {
        $this->dropTable('account_plans');
        $this->dropTable('balances');
        $this->dropTable('banks');
        $this->dropTable('boxes');
        $this->dropTable('cards');
        $this->dropTable('coins');
        $this->dropTable('costs');
        $this->dropTable('customers');
        $this->dropTable('document_types');
        $this->dropTable('event_types');
        $this->dropTable('knowledges');
        $this->dropTable('moviment_banks');
        $this->dropTable('moviment_boxes');
        $this->dropTable('moviment_cards');
        $this->dropTable('moviment_checks');
        $this->dropTable('moviment_mergeds');
        $this->dropTable('moviment_recurrents');
        $this->dropTable('moviments');
        $this->dropTable('moviments_moviment_cards');
        $this->dropTable('parameters');
        $this->dropTable('payments');
        $this->dropTable('plannings');
        $this->dropTable('providers');
        $this->dropTable('regs');
        $this->dropTable('rules');
        $this->dropTable('stk_groupings');
        $this->dropTable('stk_localizations');
        $this->dropTable('stk_product_compositions');
        $this->dropTable('stk_products');
        $this->dropTable('stk_purchase_items');
        $this->dropTable('stk_purchases');
        $this->dropTable('stk_requisition_items');
        $this->dropTable('stk_requisitions');
        $this->dropTable('stk_sell_items');
        $this->dropTable('stk_sellers');
        $this->dropTable('stk_sells');
        $this->dropTable('stk_stocks');
        $this->dropTable('support_contacts');
        $this->dropTable('transfers');
        $this->dropTable('transporters');
        $this->dropTable('users');
        $this->dropTable('users_parameters');
        $this->dropTable('versions');
    }
}
