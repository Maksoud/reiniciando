/* ATUALIZAÇÃO DO NÚMERO DE DOCUMENTO NOS MOVIMENTOS */
/******************************************************************************/
/* MOVIMENT BOXES */
/******************************************************************************/

SELECT 
moviment_boxes.id, moviment_boxes.parameters_id, moviment_boxes.ordem, moviment_boxes.moviments_id, moviment_boxes.documento, moviment_boxes.historico, moviment_boxes.valor, moviment_boxes.valorbaixa,
moviments.parameters_id, moviments.id, moviments.ordem, moviments.documento, moviments.historico, moviments.valor, moviments.valorbaixa
FROM `moviment_boxes` 
LEFT JOIN moviments ON (moviment_boxes.moviments_id = moviments.id AND moviment_boxes.parameters_id = moviments.parameters_id)
WHERE moviment_boxes.moviments_id IS NOT NULL 
  AND moviments.documento IS NOT NULL
  AND moviment_boxes.valorbaixa = moviments.valorbaixa
  AND moviment_boxes.documento IS NULL;
/***********/
UPDATE moviment_boxes 
LEFT JOIN moviments ON (moviment_boxes.moviments_id = moviments.id AND moviment_boxes.parameters_id = moviments.parameters_id)
SET moviment_boxes.documento = moviments.documento
WHERE moviment_boxes.moviments_id IS NOT NULL 
  AND moviments.documento IS NOT NULL
  AND moviment_boxes.valorbaixa = moviments.valorbaixa
  AND moviment_boxes.documento IS NULL;

/******************************************************************************/
/* Transfers */

SELECT 
moviment_boxes.id, moviment_boxes.parameters_id, moviment_boxes.ordem, moviment_boxes.transfers_id, moviment_boxes.documento, moviment_boxes.historico, moviment_boxes.valor, moviment_boxes.valorbaixa,
transfers.parameters_id, transfers.id, transfers.ordem, transfers.documento, transfers.historico, transfers.valor
FROM `moviment_boxes` 
LEFT JOIN transfers ON (moviment_boxes.transfers_id = transfers.id AND moviment_boxes.parameters_id = transfers.parameters_id)
WHERE moviment_boxes.transfers_id IS NOT NULL 
  AND transfers.documento IS NOT NULL
  AND moviment_boxes.valorbaixa = transfers.valor
  AND moviment_boxes.documento IS NULL;
/***********/
UPDATE moviment_boxes 
LEFT JOIN transfers ON (moviment_boxes.transfers_id = transfers.id AND moviment_boxes.parameters_id = transfers.parameters_id)
SET moviment_boxes.documento = transfers.documento
WHERE moviment_boxes.transfers_id IS NOT NULL 
  AND transfers.documento IS NOT NULL
  AND moviment_boxes.valorbaixa = transfers.valor
  AND moviment_boxes.documento IS NULL;

/******************************************************************************/
/* MOVIMENT CHECKS */
/******************************************************************************/

SELECT 
moviment_checks.id, moviment_checks.parameters_id, moviment_checks.ordem, moviment_checks.moviments_id, moviment_checks.documento, moviment_checks.historico, moviment_checks.valor,
moviments.parameters_id, moviments.id, moviments.ordem, moviments.documento, moviments.historico, moviments.valor, moviments.valorbaixa
FROM `moviment_checks` 
LEFT JOIN moviments ON (moviment_checks.moviments_id = moviments.id AND moviment_checks.parameters_id = moviments.parameters_id)
WHERE moviment_checks.moviments_id IS NOT NULL 
  AND moviments.documento IS NOT NULL
  AND moviment_checks.valor = moviments.valorbaixa
  AND moviment_checks.documento IS NULL;
/***********/
UPDATE moviment_checks 
LEFT JOIN moviments ON (moviment_checks.moviments_id = moviments.id AND moviment_checks.parameters_id = moviments.parameters_id)
SET moviment_checks.documento = moviments.documento
WHERE moviment_checks.moviments_id IS NOT NULL 
  AND moviments.documento IS NOT NULL
  AND moviment_checks.valor = moviments.valorbaixa
  AND moviment_checks.documento IS NULL;

/******************************************************************************/
/* Transfers */

SELECT 
moviment_checks.id, moviment_checks.parameters_id, moviment_checks.ordem, moviment_checks.transfers_id, moviment_checks.documento, moviment_checks.historico, moviment_checks.valor,
transfers.parameters_id, transfers.id, transfers.ordem, transfers.documento, transfers.historico, transfers.valor
FROM `moviment_checks` 
LEFT JOIN transfers ON (moviment_checks.transfers_id = transfers.id AND moviment_checks.parameters_id = transfers.parameters_id)
WHERE moviment_checks.transfers_id IS NOT NULL 
  AND transfers.documento IS NOT NULL
  AND moviment_checks.valor = transfers.valor
  AND moviment_checks.documento IS NULL;
/***********/
UPDATE moviment_checks 
LEFT JOIN transfers ON (moviment_checks.transfers_id = transfers.id AND moviment_checks.parameters_id = transfers.parameters_id)
SET moviment_checks.documento = transfers.documento
WHERE moviment_checks.transfers_id IS NOT NULL 
  AND transfers.documento IS NOT NULL
  AND moviment_checks.valor = transfers.valor
  AND moviment_checks.documento IS NULL;

/******************************************************************************/
/* MOVIMENT BANKS */
/******************************************************************************/

SELECT 
moviment_banks.id, moviment_banks.parameters_id, moviment_banks.ordem, moviment_banks.moviments_id, moviment_banks.documento, moviment_banks.historico, moviment_banks.valor, moviment_banks.valorbaixa,
moviments.parameters_id, moviments.id, moviments.ordem, moviments.documento, moviments.historico, moviments.valor, moviments.valorbaixa
FROM `moviment_banks` 
LEFT JOIN moviments ON (moviment_banks.moviments_id = moviments.id AND moviment_banks.parameters_id = moviments.parameters_id)
WHERE moviment_banks.moviments_id IS NOT NULL 
  AND moviments.documento IS NOT NULL
  AND moviment_banks.valor = moviments.valorbaixa
  AND moviment_banks.documento IS NULL;
/***********/
UPDATE moviment_banks 
LEFT JOIN moviments ON (moviment_banks.moviments_id = moviments.id AND moviment_banks.parameters_id = moviments.parameters_id)
SET moviment_banks.documento = moviments.documento
WHERE moviment_banks.moviments_id IS NOT NULL 
  AND moviments.documento IS NOT NULL
  AND moviment_banks.valor = moviments.valorbaixa
  AND moviment_banks.documento IS NULL;

/******************************************************************************/
/* Transfers */

SELECT 
moviment_banks.id, moviment_banks.parameters_id, moviment_banks.ordem, moviment_banks.transfers_id, moviment_banks.documento, moviment_banks.historico, moviment_banks.valor, moviment_banks.valorbaixa,
transfers.parameters_id, transfers.id, transfers.ordem, transfers.documento, transfers.historico, transfers.valor
FROM `moviment_banks` 
LEFT JOIN transfers ON (moviment_banks.transfers_id = transfers.id AND moviment_banks.parameters_id = transfers.parameters_id)
WHERE moviment_banks.transfers_id IS NOT NULL 
  AND transfers.documento IS NOT NULL
  AND moviment_banks.valor = transfers.valor
  AND moviment_banks.documento IS NULL;
/***********/
UPDATE moviment_banks 
LEFT JOIN transfers ON (moviment_banks.transfers_id = transfers.id AND moviment_banks.parameters_id = transfers.parameters_id)
SET moviment_banks.documento = transfers.documento
WHERE moviment_banks.transfers_id IS NOT NULL 
  AND transfers.documento IS NOT NULL
  AND moviment_banks.valor = transfers.valor
  AND moviment_banks.documento IS NULL;


/******************************************************************************/
/* Moviment Checks */

SELECT 
moviment_banks.id, moviment_banks.parameters_id, moviment_banks.ordem, moviment_banks.moviment_checks_id, moviment_banks.documento, moviment_banks.historico, moviment_banks.valor, moviment_banks.valorbaixa,
moviment_checks.parameters_id, moviment_checks.id, moviment_checks.ordem, moviment_checks.documento, moviment_checks.historico, moviment_checks.valor
FROM `moviment_banks` 
LEFT JOIN moviment_checks ON (moviment_banks.moviment_checks_id = moviment_checks.id AND moviment_banks.parameters_id = moviment_checks.parameters_id)
WHERE moviment_banks.moviment_checks_id IS NOT NULL 
  AND moviment_checks.documento IS NOT NULL
  AND moviment_banks.valor = moviment_checks.valor
  AND moviment_banks.documento IS NULL;
/***********/
UPDATE moviment_banks 
LEFT JOIN moviment_checks ON (moviment_banks.moviment_checks_id = moviment_checks.id AND moviment_banks.parameters_id = moviment_checks.parameters_id)
SET moviment_banks.documento = moviment_checks.documento
WHERE moviment_banks.moviment_checks_id IS NOT NULL 
  AND moviment_checks.documento IS NOT NULL
  AND moviment_banks.valor = moviment_checks.valor
  AND moviment_banks.documento IS NULL;