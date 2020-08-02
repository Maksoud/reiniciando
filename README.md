## A proposta

Iniciado em Julho de 2020, uma nova versão do sistema para controle financeiro, utilizando o **Laravel 7**, com os recursos descritos abaixo. Este projeto está hospedado em **https://reiniciando.maksoud.dev** e contará com uma opção para automatizar o PUSH para a versão mais recente do repositório.

A proposta é focar no aprendizado do framework **Laravel**, por isso foi escolhido um sistema já existente, detalhado abaixo. Todo o conhecimento adquirido nesse projeto será compartilhado no meu blog no endereço **https://www.correiarodrigues.com.br**.


## O sistema

Sistema Financeiro para uso pessoal e de uso gratuito, disponível em www.reiniciando.com.br. Conta também com uma versão comercial com taxa acessível para comércio e indústria com função de Controle de Estoques.

O sistema Reiniciando está hospedado e ativo para uso de empresas e pessoas que queiram organizar suas finanças. A ideia inicial de criar esse sistema veio da necessidade de pequenos negócios poderem se organizar de maneira simples e prática, por isso foi levada em consideração uma integração com suporte por chat ao vivo e a adaptação do conteúdo para tablets e celulares.

Esse projeto teve o início de seu desenvolvimento em março de 2016, visando atender as necessidades de controle financeiro das indústrias onde trabalhei entre 2013 e 2019 como Analista de TI. Logo após, o projeto foi atualizado para atender o controle financeiro pessoal e o controle de estoque para indústrias. Este projeto contou com a colaboração de Cristian John (https://github.com/cristianjohn) e Thomas Känzig (https://github.com/thomaskanzig), trazendo soluções e melhorias significativas que possibilitaram na versão atual do sistema.


## As principais funcionalidades do sistema:

 - Cadastro de usuários: 
   - Controle de permissões de acesso (administrador, usuário e contador (apenas emissão de relatórios))
   - Apenas administrador pode inserir/vincular novos usuários
   - Possibilidade de vincular usuário já existente ao perfil atual e atribuir uma permissão de acesso
   - Controle de quantidade de usuários cadastrados, de acordo com o plano escolhido
 - Planos de acesso
   - Limitação do cadastro de perfis
   - Limitação do cadastro de novos usuários
   - Limitação de funções para pessoa física/jurídica
 - Multi-nível de modais para fazer cadastros sem perder os dados do lançamento corrente.
 - Acesso simples a diferentes perfis de cadastro (permitindo alternar entre seu perfil pessoal, comercial e contador de forma simples e rápida).
 - Possibilidade de atribuir usuário já existente para acesso ao perfil atual com possibilidade de escolha de permissão de acesso.
 - Envio de relatório semanal/diário das contas a vencer/vencendo por e-mail, evitando assim o pagamento de juros e o esquecimento das obrigações.
 - Possibilidade de gravação de arquivos de backup em um diretório FTP com limite de quantidade, chamado através de endereço externo pelo CRON do sistema.
 - Listagem de backups em diretório local e no diretório FTP anteriormente selecionado.
 - Atualização automatizada: A função de atualização do menu de configurações executa o PUSH neste projeto.
 - Controle de chamados de suporte: Permitindo acompanhar e solucionar as solicitações, mantendo o histórico para possíveis melhorias futuras.
 - Logs de atividades, um resumo de o que, quando e quem são gravadas para realização de auditorias internas.
 - Dashboard personalizado com as seguines informações:
   - Demonstração de saldos financeiros de bancos, caixas/carteiras, limite de cartões de créditos, percentual de atendimento de planejamentos e metas definidas
   - Gráficos de receitas X despesas por mês, gráfico de saúde financeira do ano atual.
   - Resumo de receitas, despesas e resultados do mês atual com demonstração dos valores orçados, realizados e em aberto.
   - Resumo de lançamentos por planos de contas do mês atual.
   - Extratos financeiros: listagem de contas de receitas e despesas em aberto atrasadas, vencendo hoje e a vencer no mês corrente.
   - Atalhos para as principais funções de cadastrar, lançamento de títulos e relatórios.
   
   
## As principais funcionalidades do módulo financeiro:

 - Cadastros: 
   - Clientes (Nome, endereço, cidade, bairro, CEP, estado, telefone para contato, observações)
   - Fornecedores (Nome, Razão Social, CNPJ, endereço, cidade, bairro, CEP, estado, telefone para contato, pessoa de contato, observações)
   - Bancos (Nome do banco, agência, conta, tipo de conta: corrente, poupança, aplicação, salário)
   - Caixas/Carteira (Nome do caixa/carteira)
   - Planos de contas (Nome do plano de contas, categoria ascendente, tipo: receita, despesa)
   - Centros de custos/categorias (Nome do centro de custos/categoria)
   - Cartões de crédito (Bandeira, nome do cartão, dia do vencimento, melhor dia de compra)
   - Tipos de eventos (Débito em conta, crédito em conta, depósito, transferência) 
   - Tipos de documentos (Dinheiro, cheque, cartão, promissória, recibo)
 - Controle de contas a pagar e receber, movimentos de cheques (pagamentos de contas com cheques),
 - Controle de saldos de bancos, caixas/carteira, limite de cartão de crédito e planejamento e metas (separa saldo financeiro para atingir objetivos específicos)
 - Cartão de Crédito:
   - Controle de compras no cartão de crédito, com acúmulo de compras em um único lançamento no contas a pagar
   - Ajuste no lançamento para modificar o vencimento para o anterior/próximo lançamento no contas a pagar
   - Controle de melhor dia de compra e dia vencimento da fatura do cartão para calcular o dia que será acumulado o lançamento
 - Baixa de pagamentos, cancelamento de baixa e reativação de ítem cancelado.
 - Agrupamento de contas por fornecedor/cliente em aberto
 - Relatórios financeiros:
   - Relatórios de Geral: É possível combinar o saldos de bancos e caixas/carteiras, planos de contas e centros de custos/categorias, receitas e despesas, em aberto e/ou baixadas, com layout analítico, sintético e definir a ordem de exibição dos ítens.
   - Contas a pagar/receber, movimentos de caixas/carteiras, movimentos de bancos, movimentos de cheques, lançamentos de cartões, transferências entre contas e relação de pagamentos.


## As principais funcionalidades do módulo de estoques:

 - Cadastros: 
   - Produtos (Código interno, descrição, código EAN/SKU, código NCM, estoque mínimo, estoque máximo, observações, descrições secundárias: código, descrição e observações)
   - Transportadoras (Nome, Razão Social, CNPJ, endereço, cidade, bairro, CEP, estado, telefone para contato, pessoa de contato, observações)
   - Tipos de produtos (Descrição: produto acabado, matéria prima, bonificação/brinde, uso e consumo. Calcula custo do estoque: sim, não)
   - Grupos de produtos (Borrachas, madeiras, metais, vidros, tubos e conexões, juntas, ferramentas, perecíveis)
 - Pedidos de vendas, pedidos de compras, faturamentos, ordens de fabricação, solicitações de compras, requisições de estoque e emissão de inventários (em desenvolvimento).
 - Relatórios de estoques:
   - Vendas, compras, faturamentos, ordens de fabricações, solicitações de compras, requisições de compras e produtos.
   - Rastreamento de ordens de fabricação: É possível identificar para uma determinada OF as compras, requisições, faturamentos de entrada, faturamentos de saída e solicitações de compras.


## Dados do projeto

 - PHP 7.4, Laravel 7.19, banco de dados MySQL e o Apache.
 - O SQL do esquelelto do banco encontra-se na raíz do projeto em 'banco_de_dados.sql'.
 - O usuário para acesso é o **suporte@reiniciando.com.br** e a senha de acesso é **reiniciando**.
 - Endereço de acesso é o **https://reiniciando.maksoud.dev**


## Considerações Finais

 - Seu auxílio nesse projeto é muito importante! Conto com sua colaboração, ainda que seja uma pequena melhoria.
 - A ideia de desenvolver uma ferramenta que já existe, é trazer o conhecimento em CakePHP para o Laravel e assim focar no aprendizado do framework.
 - Futuro: Emissão de boletos, leitura de arquivos de bancos para baixa automática de títulos, emissão de notas fiscais, integração do controle de estoque com o sistema financeiro, controle de produção (chão de fábrica) e etc.
 - Meu principal interesse nesse projeto é disponibilizar o código-fonte desse projeto para beneficiar outras pessoas e também ajudar pequenas empresas em suas organizações. Juntos somos mais fortes!
