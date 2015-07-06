CREATE VIEW viCidades AS (SELECT c.CodCidade, c.Nome, concat(c.Nome,'/',e.UF) AS CidUf FROM cidades c
INNER JOIN estados e ON c.CodEstado = e.CodEstado)