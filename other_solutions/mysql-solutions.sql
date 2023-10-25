-- Query 1: Display total number of albums sold per artist
SELECT Artist, COUNT(Album) AS TotalAlbumsSold
FROM sample
GROUP BY Artist;

-- Query 2: Display combined album sales per artist
SELECT Artist, SUM(`2022 Sales`) AS CombinedAlbumSales
FROM sample
GROUP BY Artist;

-- Query 3: Display the top 1 artist who sold the most combined album sales
SELECT Artist, SUM(`2022 Sales`) AS CombinedAlbumSales
FROM sample
GROUP BY Artist
ORDER BY CombinedAlbumSales DESC
LIMIT 1;

-- Query 4: Display the top 10 albums per year based on their number of sales
SELECT `2022 Sales`, Album, Artist, `Date Released` 
FROM sample 
ORDER BY `2022 Sales` 
DESC LIMIT 10;

-- Query 5: Display a list of albums based on the searched artist
-- Replace 'ArtistName' with the name of the artist you want to search for
SELECT Artist, Album, `2022 Sales`, DateReleased, LastUpdate
FROM AlbumSales
WHERE Artist = 'ArtistName';