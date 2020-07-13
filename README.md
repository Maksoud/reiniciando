# Reiniciando

Sistema Financeiro para uso pessoal e de uso gratuito, disponível em www.reiniciando.com.br. Conta também com uma versão comercial com taxa acessível para comércio e indústria com função de Controle de Estoques.

O sistema Reiniciando está hospedado e ativo para uso de empresas e pessoas que queiram organizar suas finanças. A ideia inicial de criar esse sistema veio da necessidade de pequenos negócios poderem se organizar de maneira simples e prática, por isso foi levada em consideração uma integração com suporte por bate-papo em tempo real e a versão para tablets e celulares.

Esse projeto teve o início de seu desenvolvimento em março de 2016, visando atender as necessidades de controle financeiro das indústrias onde trabalhei entre 2013 e 2019 como Analista de TI. Logo após, o projeto foi atualizado para atender o maior número possível de ramos de negócios e posteriormente desenvolvi a função para controle financeiro pessoal e controle de estoque para indústrias. Este projeto contou com a colaboração de Cristian John (https://github.com/cristianjohn) e Thomas Känzig (https://github.com/thomaskanzig), trazendo soluções e melhorias significativas que possibilitaram na versão atual do sistema.


## Algumas das funcionalidades abordadas no sistema são:

 - Cadastro de usuários com controle de permissões (super-administrador, administrador, usuário e contador (apenas emissão de relatórios).
 - Multi-nível de modais para fazer cadastros no momento dos lançamentos, sem perder a continuidade do processo.
 - Acesso simples a diferentes perfis de cadastro (permitindo alternar entre seu perfil pessoal, comercial e contador de forma simples e rápida).
 - Possibilidade de atribuir usuário já existente para acesso ao perfil atual com possibilidade de escolha de permissão de acesso.
 - Envio de relatório semanal/diário das contas a vencer/vencendo por e-mail, evitando assim o pagamento de juros e o esquecimento das obrigações.
 - Possibilidade de gravação de arquivos de backup em um diretório FTP com limite de quantidade, chamado através de endereço externo pelo CRON do sistema.
 - Listagem de backups em diretório local e no diretório FTP anteriormente selecionado.
 - Atualização automatizada do código do sistema através de comandos Git.
 - Controle de chamados de suporte: Permitindo acompanhar e solucionar as solicitações, mantendo o histórico para possíveis melhorias futuras.
 - Controle de Logs de atividades, um resumo das ações tomadas e quem executou são gravadas, afim de auditoria de busca de dados perdidos.
 - Dashboard personalizado com as seguines informações:
   - Demonstração de saldos financeiros de bancos, caixas/carteiras, limite de cartões de créditos, percentual de atendimento de planejamentos e metas definidas
   - Gráficos de receitas X despesas por mês, gráfico de saúde financeira do ano atual.
   - Resumo de receitas, despesas e resultados do mês atual com demonstração dos valores orçados, realizados e em aberto.
   - Resumo de lançamentos por planos de contas do mês atual.
   - Extratos financeiros: listagem de contas de receitas e despesas em aberto atrasadas, vencendo hoje e a vencer no mês corrente.
   - Atalhos para as principais funções de cadastrar, lançamento de títulos e relatórios.
   
   
## O controle financeiro aborda as seguintes funcionalidades:

 - Cadastros de clientes, fornecedores, planos de contas, centros de custos/categorias, bancos, caixas, cartões de crédito, tipos de eventos, tipos de documentos
 - Controle de contas a pagar e receber, movimentos de cheques (pagamentos de contas com cheques),
 - Controle de saldos de bancos, caixas/carteira, limite de cartão de crédito e planejamento e metas (separa saldo financeiro para atingir objetivos específicos)
 - Função Cartão de Crédito:
   - Controle de compras no cartão de crédito, com acúmulo de compras em um único lançamento no contas a pagar
   - Ajuste no lançamento para modificar o vencimento para o anterior/próximo lançamento no contas a pagar
   - Controle de melhor dia de compra e dia vencimento da fatura do cartão para calcular o dia que será acumulado o lançamento
 - Baixa de pagamentos, cancelamento de baixa e reativação de ítem cancelado.
 - Agrupamento de contas por fornecedor/cliente em aberto
 - Relatórios financeiros:
   - Relatórios de Geral: É possível combinar o saldos de bancos e caixas/carteiras, planos de contas e centros de custos/categorias, receitas e despesas, em aberto e/ou baixadas, com layout analítico, sintético e definir a ordem de exibição dos ítens.
   - Contas a pagar/receber, movimentos de caixas/carteiras, movimentos de bancos, movimentos de cheques, lançamentos de cartões, transferências entre contas e relação de pagamentos.


## O controle de estoques aborda as seguintes funcionalidades:

 - Cadastros de produtos, transportadores, tipos de produtos e grupos de produtos.
 - Pedidos de vendas, pedidos de compras, faturamentos, ordens de fabricação, solicitações de compras, requisições de estoque e emissão de inventários (em desenvolvimento).
 - Relatórios de estoques:
   - Vendas, compras, faturamentos, ordens de fabricações, solicitações de compras, requisições de compras e produtos.
   - Rastreamento de ordens de fabricação: É possível identificar para uma determinada OF as compras, requisições, faturamentos de entrada, faturamentos de saída e solicitações de compras.


## Passos para instalação do projeto em um servidor local

 - Foi utilizado nesse projeto o PHP 7.0, CakePHP 3.4, banco de dados MySQL e o Apache.
 - O SQL do esquelelto do banco de dados (banco_de_dados.sql) encontra-se na raíz do projeto.
 - As configurações de e-mail (envio de alertas semanais e diários das contas a pagar/receber), dados de acesso ao banco de dados e código de segurança da aplicação (Security Salt) são configurados no arquivo config/app.php.
 - É necessário modificar o arquivo php.ini para adicionar as variáveis intl (extension=php_intl.dll ou apenas extension=intl). Talvez seja necessário instalar através do comando (sudo apt-get install php7.4-intl).
 - É importante redefinir as permissões de acesso das pastas de log. Assim como configurar a permissão de acesso nos arquivos '.log' do projeto.
 - O diretório webroot/database contém arquivos SQL que serão lidos pelo sistema para atualização do banco de dados, ao selecionar a opção update no menu do sistema.
 - Os dados de acesso do FTP remoto para gravação das cópias de backup, encontram-se no arquivo src/Controller/Component/FtpComponent.php.

## Versão online

 Este projeto está em execução através do endereço https://reiniciando.maksoud.dev e você pode atualizar através do menu de configurações, opção Atualizar. O usuário para acesso é o suporte@reiniciando.com.br e a senha é 12345.

## Considerações Finais

 - Seu auxílio nesse projeto é muito importante! Nunca ache que o que sabe é pouco ou o que pode ajudar é insuficiente. Contamos com sua ajuda e queremos ouvir mais sobre você. Envie um e-mail para suporte@reiniciando.com.br com suas dúvidas ou sugestões.
 - Esse projeto, apesar de já está em uso e contar com alguns clientes, ainda pode ser melhorado, e muito!
 - Espero poder criar funções para emissão de boletos, leitura de arquivos de bancos para baixa de títulos, emissão de notas fiscais, integração do controle de estoque com o sistema financeiro (evitando retrabalho no lançamento das notas no contas a pagar/receber) e outras funcionalidades.
 - Meu interesse com esse projeto é ajudar a pequenos negócios para que possam controlar suas finanças de maneira simples e com a confiabilidade de um sistema em constante melhoria. Por isso eu agradeço o seu apoio e espero que juntos nós possamos tornar o Brasil cada vez mais forte.
