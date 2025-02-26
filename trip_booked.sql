CREATE OR REPLACE VIEW trip_booked AS
SELECT 
    user.*,
    account.phone,
    trip.trip_num,
    COUNT(booking.booking_id) AS 'booked_seats'
FROM `booking`
INNER JOIN `user` ON user.ID = booking.booking_user_id
INNER JOIN `trip` ON trip.trip_num = booking.booking_trip_num
INNER JOIN `account` ON account.ID = user.account_id
GROUP BY trip.trip_num , user.ID