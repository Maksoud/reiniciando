CREATE TABLE `faturas` (
  `id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `parameters_id` int(11) DEFAULT NULL,
  `cod` varchar(80) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `valor` decimal(14,2) DEFAULT NULL,
  `tipo_pagamento` char(2) DEFAULT NULL COMMENT 'CC => Cartão de Crédito, BO => Boleto',
  `url_boleto` text,
  `token` varchar(255) DEFAULT NULL COMMENT 'Token representa o cartão de crédito usado',
  `vencimento` date DEFAULT NULL,
  `integracao` varchar(50) DEFAULT NULL COMMENT 'Identifica o nome do sistema a ser integrado com a fatura, ex. gernet',
  `transacao_id` varchar(50) DEFAULT NULL COMMENT 'Identificador da transação referente ao sistema integrado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `fatura_historicos` (
  `id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `faturas_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `transacao_status` varchar(50) DEFAULT NULL,
  `title` text COMMENT 'transacao_status tratado para exibir para o usuário'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `gerencianet_logs` (
  `id` int(11) NOT NULL,
  `token` varchar(200) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*******************************/

ALTER TABLE `faturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cod` (`cod`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `transacao_id` (`transacao_id`);

ALTER TABLE `fatura_historicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faturas_id` (`faturas_id`);

ALTER TABLE `gerencianet_logs`
  ADD PRIMARY KEY (`id`);

/*******************************/

ALTER TABLE `faturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `fatura_historicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `gerencianet_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;