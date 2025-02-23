CREATE OR REPLACE VIEW itemview AS
SELECT 
    trip.*,
    DATEDIFF(trip.start_date, CURRENT_DATE()) AS days_left,
    (trip.max_passengers - COALESCE(sub_booking.count, 0)) AS seats_left,
    categories.name AS category_name,
    categories.name_ar AS category_name_ar,
    manager.company_name AS company_name,
    manager.company_name_ar AS company_name_ar,
    trip_images.img_1 AS image_1,
    trip_images.img_2 AS image_2,
    trip_images.img_3 AS image_3,
    trip_images.img_4 AS image_4,
    trip_images.img_5 AS image_5,
    trip_destination.location_1 AS destination_1,
    trip_destination.location_2 AS destination_2,
    trip_destination.location_3 AS destination_3,
    trip_destination.location_4 AS destination_4,
    trip_destination.location_5 AS destination_5,
    trip_destination.location_1_ar AS destination_1_ar,
    trip_destination.location_2_ar AS destination_2_ar,
    trip_destination.location_3_ar AS destination_3_ar,
    trip_destination.location_4_ar AS destination_4_ar,
    trip_destination.location_5_ar AS destination_5_ar
FROM `trip`
INNER JOIN `categories` ON categories.category_id = trip.category_id
INNER JOIN `manager` ON manager.ID = trip.manager_id
LEFT JOIN `trip_destination` ON trip_destination.trip_num = trip.trip_num
LEFT JOIN `trip_images` ON trip_images.trip_num = trip.trip_num
LEFT JOIN (
    SELECT booking_trip_num, COUNT(booking_id) AS count 
    FROM `booking`
    GROUP BY booking_trip_num
) AS sub_booking ON sub_booking.booking_trip_num = trip.trip_num;
