CREATE TABLE `industrialization_items` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `industrializations_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(10,4) NOT NULL,
  `unity` varchar(5) NOT NULL,
  `obs` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `industrialization_items`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `industrialization_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `industrializations` CHANGE `certificate` `certificado` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Certificado de matéria-prima; Certificado de Garantia; Certificado de calibração de equipamento.';
ALTER TABLE `industrializations` CHANGE `penalty` `multa` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `industrializations` CHANGE `inspection` `inspecao` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `industrializations`  
  ADD `pit` CHAR(1) NULL COMMENT 'Plano de Inspeção e Testes'  AFTER `certificate`,  
  ADD `fichaEmergencia` CHAR(1) NULL  AFTER `pit`,  
  ADD `fluido` VARCHAR(80) NULL  AFTER `fichaEmergencia`,  
  ADD `projeto` CHAR(1) NULL  AFTER `fluido`,  
  ADD `temperatura` VARCHAR(80) NULL  AFTER `projeto`,  
  ADD `are` CHAR(1) NULL COMMENT 'Aditivo de Reforço Estrutural'  AFTER `temperatura`,  
  ADD `instalacao` VARCHAR(80) NULL COMMENT 'Tipo de Instalação'  AFTER `are`,  
  ADD `posCura` CHAR(1) NULL  AFTER `instalacao`,  
  ADD `pintura` VARCHAR(80) NULL  AFTER `posCura`,  
  ADD `duracao` VARCHAR(80) NULL  AFTER `pintura`,  
  ADD `compraTerceiros` VARCHAR(80) NULL  AFTER `duracao`,  
  ADD `localEntrega` VARCHAR(80) NULL  AFTER `compraTerceiros`,  
  ADD `resinabq` VARCHAR(80) NULL COMMENT 'Barreira Química'  AFTER `localEntrega`,  
  ADD `catalizadorbq` VARCHAR(80) NULL COMMENT 'Barreira Química'  AFTER `resinabq`,  
  ADD `espessurabq` VARCHAR(80) NULL COMMENT 'Barreira Química'  AFTER `catalizadorbq`,  
  ADD `resinare` VARCHAR(80) NULL COMMENT 'Reforço Estrutural'  AFTER `espessurabq`,  
  ADD `catalizadorre` VARCHAR(80) NULL COMMENT 'Reforço Estrutural'  AFTER `resinare`,  
  ADD `espessurare` VARCHAR(80) NULL COMMENT 'Reforço Estrutural'  AFTER `catalizadorre`,  
  ADD `emitente` VARCHAR(80) NULL  AFTER `espessurare`,  
  ADD `qualidade` VARCHAR(80) NULL  AFTER `emitente`,  
  ADD `autorizacao1` VARCHAR(80) NULL  AFTER `qualidade`,  
  ADD `autorizacao2` VARCHAR(80) NULL  AFTER `autorizacao1`;