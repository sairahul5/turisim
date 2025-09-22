-- Create the tourism search database
CREATE DATABASE IF NOT EXISTS tourism_search_db;
USE tourism_search_db;

-- Create the places table
CREATE TABLE places (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    type ENUM('Homestay', 'Location') NOT NULL,
    city VARCHAR(100) NOT NULL,
    description TEXT
);

INSERT INTO places (name, type, city, description) VALUES
('The Beach House Homestay', 'Homestay', 'Goa', 'Cozy beachfront homestay with traditional Goan architecture and home-cooked meals. Perfect for families seeking authentic coastal experience.'),

('Red Fort Heritage Complex', 'Location', 'Delhi', 'Historic Mughal fortress and UNESCO World Heritage site. Marvel at the stunning red sandstone architecture and rich history of India.'),

('Spice Garden Family Stay', 'Homestay', 'Goa', 'Traditional homestay surrounded by spice plantations. Enjoy organic meals and guided spice garden tours with local family hosts.'),

('India Gate Memorial', 'Location', 'Delhi', 'Iconic war memorial and popular picnic spot. Beautiful lawns and evening illumination make it perfect for family outings and photography.'),

('Heritage Haveli Homestay', 'Homestay', 'Delhi', 'Restored traditional Delhi haveli offering authentic North Indian culture. Experience royal hospitality with modern amenities in old Delhi charm.'),


('Sunset Beach Villa', 'Homestay', 'Goa Gova', 'Luxury beachfront villa with panoramic ocean views and private beach access.'),

('Lotus Temple', 'Location', 'Delhi New Delhi', 'Stunning Bahai House of Worship known for its unique lotus-shaped architecture and peaceful meditation gardens.'),

('Backwater Homestay', 'Homestay', 'Goa Panaji', 'Authentic Goan experience near famous backwaters with traditional fishing and local cuisine.'),

('Qutub Minar', 'Location', 'Delhi NCR', 'UNESCO World Heritage site featuring the tallest brick minaret in the world with intricate Islamic architecture.'),

('Mountain View Retreat', 'Homestay', 'Goa South Goa', 'Peaceful hillside homestay offering trekking, bird watching and organic farm-to-table dining.');