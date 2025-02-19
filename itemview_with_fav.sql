SELECT itemview.* ,1 AS favorite FROM itemview
INNER JOIN favorite ON itemview.trip_num = favorite.favorite_trip_num AND favorite.favorite_user_id = 2
WHERE category_id = 1 AND itemview.start_date > 2025-2-10
UNION ALL
SELECT itemview.* ,0 AS favorite FROM itemview
WHERE category_id = 1 AND itemview.start_date > 2025-2-10 AND itemview.trip_num NOT IN (SELECT itemview.trip_num FROM itemview
INNER JOIN favorite ON itemview.trip_num = favorite.favorite_trip_num AND favorite.favorite_user_id = 2)