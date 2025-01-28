CREATE OR REPLACE VIEW myFavorite AS
SELECT 
	favorite.* , 
    trip.* , 
    user.ID,
    categories.name AS category_name,
    categories.name_ar AS category_name_ar,
    manager.company_name AS company_name,
    trip_images.img_1 AS image_1,
    trip_images.img_2 AS image_2,
    trip_images.img_3 AS image_3,
    trip_images.img_4 AS image_4,
    trip_images.img_5 AS image_5,
    trip_destination.location_1 AS destination_1,
    trip_destination.location_2 AS destination_2,
    trip_destination.location_3 AS destination_3,
    trip_destination.location_4 AS destination_4,
    trip_destination.location_5 AS destination_5
FROM favorite 
INNER JOIN trip ON favorite.favorite_trip_num = trip.trip_num
INNER JOIN user ON favorite.favorite_user_id = user.ID
INNER JOIN `categories` ON categories.category_id = trip.category_id
INNER JOIN `manager` ON manager.ID = trip.manager_id
INNER JOIN `trip_destination` ON trip_destination.trip_num = trip.trip_num
INNER JOIN `trip_images` ON trip_images.trip_num = trip.trip_num