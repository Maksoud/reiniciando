/*
SELECT moviment_cards.id, moviment_cards.parameters_id, 
moviment_cards.cards_id, moviment_cards.moviments_id, 
moviment_cards.vencimento, moviment_cards.title, 
moviments.ordem 
FROM moviment_cards
LEFT JOIN moviments 
ON moviments.cards_id = moviment_cards.cards_id 
AND moviments.vencimento = moviment_cards.vencimento
AND moviments.parameters_id = moviment_cards.parameters_id
*/
/*
FUNÇÃO ADICIONA O VÍNCULO ENTRE OS LANÇAMENTOS CPR E O MOVIMENTO DE CARTÃO. SUBSTITUÍDO PELO ID EM 24-01-2018
UPDATE moviment_cards 
LEFT JOIN moviments 
       ON moviments.cards_id = moviment_cards.cards_id 
      AND moviments.vencimento = moviment_cards.vencimento
      AND moviments.parameters_id = moviment_cards.parameters_id
  SET moviment_cards.moviments_id = moviments.ordem
WHERE moviments.cards_id = moviment_cards.cards_id 
  AND moviments.vencimento = moviment_cards.vencimento
  AND moviments.parameters_id = moviment_cards.parameters_id
*/