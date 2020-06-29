/* Moviment Banks */

SELECT 
moviment_banks.id, moviment_banks.parameters_id, moviment_banks.ordem, moviment_banks.documento, moviment_banks.historico, moviment_banks.moviments_id,
moviments.parameters_id, moviments.id, moviments.ordem, moviments.documento, moviments.historico
FROM `moviment_banks` 
LEFT JOIN moviments ON (moviment_banks.moviments_id = moviments.id AND moviment_banks.parameters_id = moviments.parameters_id)
WHERE moviment_banks.moviments_id IS NOT NULL 
AND moviment_banks.parameters_id = '11'
AND moviment_banks.documento <> moviments.documento;
/***********/


/******************************************************************************/

/* Moviment Boxes */

SELECT 
moviment_boxes.id, moviment_boxes.parameters_id, moviment_boxes.ordem, moviment_boxes.documento, moviment_boxes.historico, moviment_boxes.moviments_id,
moviments.parameters_id, moviments.id, moviments.ordem, moviments.documento, moviments.historico
FROM `moviment_boxes` 
LEFT JOIN moviments ON (moviment_boxes.moviments_id = moviments.id AND moviment_boxes.parameters_id = moviments.parameters_id)
WHERE moviment_boxes.moviments_id IS NOT NULL 
AND moviment_boxes.parameters_id = '11'
AND moviment_boxes.documento <> moviments.documento;
/***********/


/******************************************************************************/

/* Moviment Cards */

SELECT 
moviment_cards.id, moviment_cards.parameters_id, moviment_cards.ordem, moviment_cards.documento, moviment_cards.title, moviment_cards.moviments_id,
moviments.parameters_id, moviments.id, moviments.ordem, moviments.documento, moviments.historico
FROM `moviment_cards` 
LEFT JOIN moviments ON (moviment_cards.moviments_id = moviments.id AND moviment_cards.parameters_id = moviments.parameters_id)
WHERE moviment_cards.moviments_id IS NOT NULL 
AND moviment_cards.parameters_id = '11'
AND moviment_cards.documento <> moviments.documento;
/***********/

/******************************************************************************/
/* Transfers */

/* Moviment Boxes */
SELECT 
transfers.id, transfers.parameters_id, transfers.ordem, transfers.documento, transfers.historico,
moviment_boxes.transfers_id, moviment_boxes.parameters_id, moviment_boxes.id, moviment_boxes.ordem, moviment_boxes.documento, moviment_boxes.historico
FROM `transfers` 
LEFT JOIN moviment_boxes ON (moviment_boxes.transfers_id = transfers.id AND transfers.parameters_id = moviment_boxes.parameters_id)
WHERE moviment_boxes.transfers_id IS NOT NULL 
AND transfers.parameters_id = moviment_boxes.parameters_id
AND transfers.documento <> moviment_boxes.documento;
/***********/
/* Moviment Banks */
SELECT 
transfers.id, transfers.parameters_id, transfers.ordem, transfers.documento, transfers.historico,
moviment_banks.transfers_id, moviment_banks.parameters_id, moviment_banks.id, moviment_banks.ordem, moviment_banks.documento, moviment_banks.historico
FROM `transfers` 
LEFT JOIN moviment_banks ON (moviment_banks.transfers_id = transfers.id AND transfers.parameters_id = moviment_banks.parameters_id)
WHERE moviment_banks.transfers_id IS NOT NULL 
AND transfers.parameters_id = moviment_banks.parameters_id
AND transfers.documento <> moviment_banks.documento;



