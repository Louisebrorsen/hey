--Data til oprettelse af reservationer og sæde-reservationer
--Udarbejdet med henblik på testning af systemet
--Antager at userID, screeningID og seatID allerede eksisterer i databasen
--Reservationer med tilhørende sæde-reservationer

--Tilføjet ny trigger for automatisk opdatering af total_price i reservation-tabellen
--Triggeren opdaterer total_price baseret på antallet af reserverede sæder og prisen for den tilknyttede screening
--Både ved indsættelse og fjernelse af sæder giver opdatering af reservationer

-- R1 (2 sæder)
INSERT INTO reservation (userID, screeningID, reservation_date, total_price)
VALUES (12, 36, CURDATE(), 0);
SET @rid = LAST_INSERT_ID();
INSERT INTO seatReservation (reservationID, seatID)
VALUES (@rid, 1), (@rid, 2);

-- R2 (1 sæde)
INSERT INTO reservation (userID, screeningID, reservation_date, total_price)
VALUES (13, 109, CURDATE(), 0);
SET @rid = LAST_INSERT_ID();
INSERT INTO seatReservation (reservationID, seatID)
VALUES (@rid, 3);

-- R3 (3 sæder)
INSERT INTO reservation (userID, screeningID, reservation_date, total_price)
VALUES (14, 75, CURDATE(), 0);
SET @rid = LAST_INSERT_ID();
INSERT INTO seatReservation (reservationID, seatID)
VALUES (@rid, 4), (@rid, 5), (@rid, 6);

-- R4 (2 sæder)
INSERT INTO reservation (userID, screeningID, reservation_date, total_price)
VALUES (15, 184, CURDATE(), 0);
SET @rid = LAST_INSERT_ID();
INSERT INTO seatReservation (reservationID, seatID)
VALUES (@rid, 7), (@rid, 8);

-- R5 (4 sæder)
INSERT INTO reservation (userID, screeningID, reservation_date, total_price)
VALUES (16, 164, CURDATE(), 0);
SET @rid = LAST_INSERT_ID();
INSERT INTO seatReservation (reservationID, seatID)
VALUES (@rid, 9), (@rid, 10), (@rid, 11), (@rid, 12);

-- R6 (1 sæde)
INSERT INTO reservation (userID, screeningID, reservation_date, total_price)
VALUES (17, 135, CURDATE(), 0);
SET @rid = LAST_INSERT_ID();
INSERT INTO seatReservation (reservationID, seatID)
VALUES (@rid, 13);

-- R7 (2 sæder)
INSERT INTO reservation (userID, screeningID, reservation_date, total_price)
VALUES (18, 143, CURDATE(), 0);
SET @rid = LAST_INSERT_ID();
INSERT INTO seatReservation (reservationID, seatID)
VALUES (@rid, 14), (@rid, 15);

-- R8 (3 sæder)
INSERT INTO reservation (userID, screeningID, reservation_date, total_price)
VALUES (19, 257, CURDATE(), 0);
SET @rid = LAST_INSERT_ID();
INSERT INTO seatReservation (reservationID, seatID)
VALUES (@rid, 16), (@rid, 17), (@rid, 18);

-- R9 (2 sæder)
INSERT INTO reservation (userID, screeningID, reservation_date, total_price)
VALUES (20, 188, CURDATE(), 0);
SET @rid = LAST_INSERT_ID();
INSERT INTO seatReservation (reservationID, seatID)
VALUES (@rid, 19), (@rid, 20);

-- R10 (1 sæde)
INSERT INTO reservation (userID, screeningID, reservation_date, total_price)
VALUES (21, 274, CURDATE(), 0);
SET @rid = LAST_INSERT_ID();
INSERT INTO seatReservation (reservationID, seatID)
VALUES (@rid, 21);