/* ATUALIZAÇÃO DO VÍNCULO ENTRE CPR E MOVIMENTOS */
/******************************************************************************/
/* MOVIMENT BOXES */
/******************************************************************************/

SELECT 
moviment_boxes.id, moviment_boxes.parameters_id, moviment_boxes.ordem, moviment_boxes.moviments_id, moviment_boxes.documento, moviment_boxes.historico, moviment_boxes.valor, moviment_boxes.valorbaixa,
moviments.parameters_id, moviments.id, moviments.ordem, moviments.documento, moviments.historico, moviments.valor, moviments.valorbaixa
FROM `moviment_boxes` 
LEFT JOIN moviments ON (moviment_boxes.moviments_id = moviments.ordem AND moviment_boxes.parameters_id = moviments.parameters_id)
WHERE moviment_boxes.moviments_id IS NOT NULL 
AND moviment_boxes.moviments_id = moviments.ordem
AND moviment_boxes.parameters_id = moviments.parameters_id
AND moviment_boxes.valorbaixa = moviments.valorbaixa
AND moviments.id <> moviments.ordem;
/***********/
UPDATE moviment_boxes 
LEFT JOIN moviments ON (moviment_boxes.moviments_id = moviments.ordem AND moviment_boxes.parameters_id = moviments.parameters_id)
SET moviment_boxes.moviments_id = moviments.id
WHERE moviment_boxes.moviments_id IS NOT NULL 
AND moviment_boxes.moviments_id = moviments.ordem
AND moviment_boxes.parameters_id = moviments.parameters_id
AND moviment_boxes.valorbaixa = moviments.valorbaixa
AND moviments.id <> moviments.ordem;

/******************************************************************************/
/* Transfers */

SELECT 
moviment_boxes.id, moviment_boxes.parameters_id, moviment_boxes.ordem, moviment_boxes.transfers_id, moviment_boxes.documento, moviment_boxes.historico, moviment_boxes.valor, moviment_boxes.valorbaixa,
transfers.parameters_id, transfers.id, transfers.ordem, transfers.documento, transfers.historico, transfers.valor
FROM `moviment_boxes` 
LEFT JOIN transfers ON (moviment_boxes.transfers_id = transfers.ordem AND moviment_boxes.parameters_id = transfers.parameters_id)
WHERE moviment_boxes.transfers_id IS NOT NULL 
AND moviment_boxes.transfers_id = transfers.ordem
AND moviment_boxes.parameters_id = transfers.parameters_id
AND moviment_boxes.valor = transfers.valor
AND transfers.id <> transfers.ordem;
/***********/
UPDATE moviment_boxes 
LEFT JOIN transfers ON (moviment_boxes.transfers_id = transfers.ordem AND moviment_boxes.parameters_id = transfers.parameters_id)
SET moviment_boxes.transfers_id = transfers.id
WHERE moviment_boxes.transfers_id IS NOT NULL 
AND moviment_boxes.transfers_id = transfers.ordem
AND moviment_boxes.parameters_id = transfers.parameters_id
AND moviment_boxes.valor = transfers.valor
AND transfers.id <> transfers.ordem;

/******************************************************************************/
/* MOVIMENT BANKS */
/******************************************************************************/

SELECT 
moviment_banks.id, moviment_banks.parameters_id, moviment_banks.ordem, moviment_banks.moviments_id, moviment_banks.documento, moviment_banks.historico, moviment_banks.valor, moviment_banks.valorbaixa,
moviments.parameters_id, moviments.id, moviments.ordem, moviments.documento, moviments.historico, moviments.valor, moviments.valorbaixa
FROM `moviment_banks` 
LEFT JOIN moviments ON (moviment_banks.moviments_id = moviments.ordem AND moviment_banks.parameters_id = moviments.parameters_id)
WHERE moviment_banks.moviments_id IS NOT NULL 
AND moviment_banks.moviments_id = moviments.ordem
AND moviment_banks.parameters_id = moviments.parameters_id
AND moviment_banks.valorbaixa = moviments.valorbaixa
AND moviments.id <> moviments.ordem;
/***********/
UPDATE moviment_banks 
LEFT JOIN moviments ON (moviment_banks.moviments_id = moviments.ordem AND moviment_banks.parameters_id = moviments.parameters_id)
SET moviment_banks.moviments_id = moviments.id
WHERE moviment_banks.moviments_id IS NOT NULL 
AND moviment_banks.moviments_id = moviments.ordem
AND moviment_banks.parameters_id = moviments.parameters_id
AND moviment_banks.valorbaixa = moviments.valorbaixa
AND moviments.id <> moviments.ordem;

/******************************************************************************/
/* Transfers */

SELECT 
moviment_banks.id, moviment_banks.parameters_id, moviment_banks.ordem, moviment_banks.transfers_id, moviment_banks.documento, moviment_banks.historico, moviment_banks.valor, moviment_banks.valorbaixa,
transfers.parameters_id, transfers.id, transfers.ordem, transfers.documento, transfers.historico, transfers.valor
FROM `moviment_banks` 
LEFT JOIN transfers ON (moviment_banks.transfers_id = transfers.ordem AND moviment_banks.parameters_id = transfers.parameters_id)
WHERE moviment_banks.transfers_id IS NOT NULL 
AND moviment_banks.transfers_id = transfers.ordem
AND moviment_banks.parameters_id = transfers.parameters_id
AND moviment_banks.valor = transfers.valor
AND transfers.id <> transfers.ordem;
/***********/
UPDATE moviment_banks 
LEFT JOIN transfers ON (moviment_banks.transfers_id = transfers.ordem AND moviment_banks.parameters_id = transfers.parameters_id)
SET moviment_banks.transfers_id = transfers.id
WHERE moviment_banks.transfers_id IS NOT NULL 
AND moviment_banks.transfers_id = transfers.ordem
AND moviment_banks.parameters_id = transfers.parameters_id
AND moviment_banks.valor = transfers.valor
AND transfers.id <> transfers.ordem;

/******************************************************************************/
/* Moviment Checks */

SELECT 
moviment_banks.id, moviment_banks.parameters_id, moviment_banks.ordem, moviment_banks.moviment_checks_id, moviment_banks.documento, moviment_banks.historico, moviment_banks.valor, moviment_banks.valorbaixa,
moviment_checks.parameters_id, moviment_checks.id, moviment_checks.ordem, moviment_checks.documento, moviment_checks.historico, moviment_checks.valor
FROM `moviment_banks` 
LEFT JOIN moviment_checks ON (moviment_banks.moviment_checks_id = moviment_checks.ordem AND moviment_banks.parameters_id = moviment_checks.parameters_id)
WHERE moviment_banks.moviment_checks_id IS NOT NULL 
AND moviment_banks.moviment_checks_id = moviment_checks.ordem
AND moviment_banks.parameters_id = moviment_checks.parameters_id
AND moviment_banks.valorbaixa = moviment_checks.valor
AND moviment_checks.id <> moviment_checks.ordem;
/***********/
UPDATE moviment_banks 
LEFT JOIN moviment_checks ON (moviment_banks.moviment_checks_id = moviment_checks.ordem AND moviment_banks.parameters_id = moviment_checks.parameters_id)
SET moviment_banks.moviment_checks_id = moviment_checks.id
WHERE moviment_banks.moviment_checks_id IS NOT NULL 
AND moviment_banks.moviment_checks_id = moviment_checks.ordem
AND moviment_banks.parameters_id = moviment_checks.parameters_id
AND moviment_banks.valorbaixa = moviment_checks.valor
AND moviment_checks.id <> moviment_checks.ordem;

/******************************************************************************/
/* MOVIMENT CHECKS */
/******************************************************************************/

/*AJUSTE NOS CADASTROS*/
SELECT 
moviment_checks.id, moviment_checks.parameters_id, moviment_checks.ordem, moviment_checks.moviments_id, moviment_checks.documento, moviment_checks.cheque, moviment_checks.historico, moviment_checks.valor,
moviments.parameters_id, moviments.id, moviments.ordem, moviments.documento, moviments.cheque, moviments.historico, moviments.valor, moviments.valorbaixa
FROM `moviment_checks` 
LEFT JOIN moviments ON (moviment_checks.moviments_id = moviments.ordem AND 
                        moviment_checks.parameters_id = moviments.parameters_id AND
                        moviment_checks.cheque = moviments.cheque)
WHERE moviment_checks.valor = moviments.valor
AND moviments.valor <> moviments.valorbaixa
AND moviment_checks.moviments_id <> moviments.id
AND moviments.id <> moviments.ordem;
/***********/
UPDATE moviment_checks 
LEFT JOIN moviments ON (moviment_checks.moviments_id = moviments.ordem AND 
                        moviment_checks.parameters_id = moviments.parameters_id AND
                        moviment_checks.cheque = moviments.cheque)
SET moviment_checks.valor = moviments.valorbaixa
WHERE moviment_checks.valor = moviments.valor
AND moviments.valor <> moviments.valorbaixa
AND moviment_checks.moviments_id <> moviments.id
AND moviments.id <> moviments.ordem;

/***********/

SELECT 
moviment_checks.id, moviment_checks.parameters_id, moviment_checks.ordem, moviment_checks.moviments_id, moviment_checks.documento, moviment_checks.cheque, moviment_checks.historico, moviment_checks.valor,
moviments.parameters_id, moviments.id, moviments.ordem, moviments.documento, moviments.cheque, moviments.historico, moviments.valor, moviments.valorbaixa
FROM `moviment_checks` 
LEFT JOIN moviments ON (moviment_checks.moviments_id = moviments.ordem AND 
                        moviment_checks.parameters_id = moviments.parameters_id AND
                        moviment_checks.cheque = moviments.cheque)
WHERE moviment_checks.moviments_id IS NOT NULL 
AND moviment_checks.valor = moviments.valorbaixa
AND moviments.id <> moviments.ordem;
/***********/
UPDATE moviment_checks 
LEFT JOIN moviments ON (moviment_checks.moviments_id = moviments.ordem AND 
                        moviment_checks.parameters_id = moviments.parameters_id AND
                        moviment_checks.cheque = moviments.cheque)
SET moviment_checks.moviments_id = moviments.id
WHERE moviment_checks.moviments_id IS NOT NULL 
AND moviment_checks.valor = moviments.valorbaixa
AND moviments.id <> moviments.ordem;

/******************************************************************************/
/* Transfers */

SELECT 
moviment_checks.id, moviment_checks.parameters_id, moviment_checks.ordem, moviment_checks.transfers_id, moviment_checks.documento, moviment_checks.historico, moviment_checks.valor,
transfers.parameters_id, transfers.id, transfers.ordem, transfers.documento, transfers.historico, transfers.valor
FROM `moviment_checks` 
LEFT JOIN transfers ON (moviment_checks.transfers_id = transfers.ordem AND moviment_checks.parameters_id = transfers.parameters_id)
WHERE moviment_checks.transfers_id IS NOT NULL 
AND moviment_checks.transfers_id = transfers.ordem
AND moviment_checks.parameters_id = transfers.parameters_id
AND moviment_checks.valor = transfers.valor
AND transfers.id <> transfers.ordem;
/***********/
UPDATE moviment_checks 
LEFT JOIN transfers ON (moviment_checks.transfers_id = transfers.ordem AND moviment_checks.parameters_id = transfers.parameters_id)
SET moviment_checks.transfers_id = transfers.id
WHERE moviment_checks.transfers_id IS NOT NULL 
AND moviment_checks.transfers_id = transfers.ordem
AND moviment_checks.parameters_id = transfers.parameters_id
AND moviment_checks.valor = transfers.valor
AND transfers.id <> transfers.ordem;

/******************************************************************************/
/* MOVIMENT CARDS */
/******************************************************************************/

SELECT 
moviment_cards.id, moviment_cards.parameters_id, moviment_cards.cards_id, moviment_cards.ordem, moviment_cards.moviments_id, moviment_cards.documento, moviment_cards.title, moviment_cards.vencimento, moviment_cards.valor, moviment_cards.valorbaixa,
moviments.parameters_id, moviments.cards_id, moviments.id, moviments.ordem, moviments.documento, moviments.historico, moviments.vencimento, moviments.valor, moviments.valorbaixa
FROM `moviment_cards` 
LEFT JOIN moviments ON (moviment_cards.cards_id = moviments.cards_id AND 
                        moviment_cards.parameters_id = moviments.parameters_id AND
                        moviment_cards.vencimento = moviments.vencimento)
WHERE moviment_cards.moviments_id IS NULL;
/***********/
UPDATE moviment_cards
LEFT JOIN moviments ON (moviment_cards.cards_id = moviments.cards_id AND 
                        moviment_cards.parameters_id = moviments.parameters_id AND
                        moviment_cards.vencimento = moviments.vencimento)
SET moviment_cards.moviments_id = moviments.id
WHERE moviment_cards.moviments_id IS NULL;