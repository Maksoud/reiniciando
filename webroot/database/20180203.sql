/* Atualização do cards_id no moviments */
SELECT
moviments.id, 
moviments.parameters_id,
moviments.cards_id,
moviments.historico,
moviments.valor,
moviments.vencimento
FROM moviments
WHERE 
moviments.vencimento IN ('2017-10-05', '2017-11-05', '2017-12-05', '2018-01-05', '2018-02-05') AND 
moviments.parameters_id = '76' AND
moviments.cards_id IS NULL;

UPDATE moviments 
SET moviments.cards_id = '21'
WHERE 
moviments.vencimento IN ('2017-10-05', '2017-11-05', '2017-12-05', '2018-01-05', '2018-02-05') AND 
moviments.parameters_id = '76' AND
moviments.cards_id IS NULL;

/******************************************************************************/

/* Atualização dos movimentos de cartões que não estão vinculados aos lançamentos de cartões */
SELECT 
moviment_cards.parameters_id,
moviment_cards.vencimento,
moviment_cards.moviments_id,
moviment_cards.id,
moviment_cards.ordem,
moviment_cards.cards_id,
moviment_cards.title,
moviment_cards.valor
FROM moviment_cards 
WHERE moviments_id IS NULL;


UPDATE moviment_cards SET moviments_id = '3224' WHERE moviment_cards.id = '1569';
UPDATE moviment_cards SET moviments_id = '3224' WHERE moviment_cards.id = '1570';
UPDATE moviment_cards SET moviments_id = '3304' WHERE moviment_cards.id = '1611';
UPDATE moviment_cards SET moviments_id = '3304' WHERE moviment_cards.id = '1612';
UPDATE moviment_cards SET moviments_id = '3383' WHERE moviment_cards.id = '1657';
UPDATE moviment_cards SET moviments_id = '3383' WHERE moviment_cards.id = '1658';
UPDATE moviment_cards SET moviments_id = '3487' WHERE moviment_cards.id = '1711';
UPDATE moviment_cards SET moviments_id = '3487' WHERE moviment_cards.id = '1712';
UPDATE moviment_cards SET moviments_id = '3592' WHERE moviment_cards.id = '1746';
UPDATE moviment_cards SET moviments_id = '3592' WHERE moviment_cards.id = '1747';

/*
3224 '2017-10-05'
3304 '2017-11-05'
3383 '2017-12-05'
3487 '2018-01-05'
3592 '2018-02-05'
*/