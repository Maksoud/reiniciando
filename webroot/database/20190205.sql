ALTER TABLE `invoices` CHANGE `type` `type` CHAR(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'V - Venda, C - Compra, SA - Saída Avulsa, EA - Entrada Avulsa';
ALTER TABLE `invoices` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P - Em Entrega, C - Cancelado, F - Finalizado';
ALTER TABLE `purchases` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P - Pendente, A - Em Entrega, C - Cancelado, F - Finalizado';
ALTER TABLE `sells` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P - Pendente, A - Em Entrega, C - Cancelado, F - Finalizado';
ALTER TABLE `purchase_requests` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P - Pendente, A - Em Andamento, C - Cancelado, F - Finalizado';
