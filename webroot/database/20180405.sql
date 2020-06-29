/* MODIFICA CADASTROS AUTOMÁTICOS DO TIPO C PARA O TIPO T */
UPDATE account_plans SET status = 'T' WHERE status = 'C';
UPDATE costs SET status = 'T' WHERE status = 'C';
UPDATE document_types SET status = 'T' WHERE status = 'C';
UPDATE event_types SET status = 'T' WHERE status = 'C';