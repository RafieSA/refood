-- =====================================================
-- REFOOD SAMPLE DATA SEEDER - READY TO EXECUTE
-- Generated: 2025-10-26
-- Restaurant IDs: UPDATED WITH ACTUAL DATA
-- =====================================================

-- =====================================================
-- SAMPLE COMMENTS/REVIEWS DATA
-- =====================================================

-- Restaurant 1: Ayam Bakar Madu (Highly rated - 4.5 stars average)
INSERT INTO coments (name, rating, coments, restaurant_id, created_at) VALUES
('Sarah Johnson', 5, 'Ayam bakarnya enak banget! Bumbu madunya pas, tidak terlalu manis. Dengan diskon jadi lebih worth it!', '14e0519d-170b-4838-a5c4-0734e9926c39', NOW() - INTERVAL '5 days'),
('Michael Chen', 4, 'Porsinya besar dan harganya terjangkau. Pelayanan ramah.', '14e0519d-170b-4838-a5c4-0734e9926c39', NOW() - INTERVAL '3 days'),
('Emma Williams', 5, 'Best ayam bakar in town! Dagingnya empuk dan bumbunya meresap sempurna.', '14e0519d-170b-4838-a5c4-0734e9926c39', NOW() - INTERVAL '2 days'),
('David Martinez', 4, 'Great value for money dengan diskon. Pasti balik lagi!', '14e0519d-170b-4838-a5c4-0734e9926c39', NOW() - INTERVAL '1 day');

-- Restaurant 2: Soto Ayam Lamongan (Medium-high rated - 4.0 stars average)
INSERT INTO coments (name, rating, coments, restaurant_id, created_at) VALUES
('Lisa Anderson', 4, 'Sotonya segar dan kuahnya gurih. Cocok untuk sarapan atau makan siang.', 'b9b7550a-8487-4b84-bd1e-78c335be5fbe', NOW() - INTERVAL '4 days'),
('James Wilson', 4, 'Authentic Soto Lamongan! Koyanya enak dan bumbu kacangnya pas.', 'b9b7550a-8487-4b84-bd1e-78c335be5fbe', NOW() - INTERVAL '2 days'),
('Sophie Taylor', 5, 'Recommended! Soto paling enak yang pernah saya coba. Sambalnya mantap!', 'b9b7550a-8487-4b84-bd1e-78c335be5fbe', NOW() - INTERVAL '1 day'),
('Robert Brown', 3, 'Enak sih, tapi harganya agak mahal meskipun sudah diskon.', 'b9b7550a-8487-4b84-bd1e-78c335be5fbe', NOW() - INTERVAL '8 hours');

-- Restaurant 3: Rendang Daging Sapi (Excellent rated - 4.8 stars)
INSERT INTO coments (name, rating, coments, restaurant_id, created_at) VALUES
('Amanda Garcia', 5, 'Rendangnya juara! Bumbunya kaya rempah dan dagingnya empuk banget.', '93b1b715-53c9-4505-8abd-fb611a7f5881', NOW() - INTERVAL '6 days'),
('Kevin Lee', 5, 'Outstanding! Ini rendang terbaik yang pernah saya makan. Authentic Minang taste!', '93b1b715-53c9-4505-8abd-fb611a7f5881', NOW() - INTERVAL '3 days'),
('Maria Rodriguez', 5, 'Perfect! Bumbu rendangnya meresap sempurna. Must try!', '93b1b715-53c9-4505-8abd-fb611a7f5881', NOW() - INTERVAL '2 days'),
('John Smith', 4, 'Very good! Agak sedikit pedas tapi sangat enak. Recommended!', '93b1b715-53c9-4505-8abd-fb611a7f5881', NOW() - INTERVAL '1 day');

-- Restaurant 4: Gulai Ikan Kakap (Good rated - 4.2 stars)
INSERT INTO coments (name, rating, coments, restaurant_id, created_at) VALUES
('Patricia Davis', 4, 'Gulainya enak, ikannya segar. Kuahnya gurih dan tidak terlalu berminyak.', 'b68f7ef0-a2ff-4fa5-bbe8-5e21ba855ff6', NOW() - INTERVAL '7 days'),
('Daniel Kim', 5, 'Ikan kakap segar! Gulainya kental dan bumbunya pas. Suka banget!', 'b68f7ef0-a2ff-4fa5-bbe8-5e21ba855ff6', NOW() - INTERVAL '4 days'),
('Jennifer Lopez', 4, 'Enak dan porsinya banyak. Cocok untuk makan bersama keluarga.', 'b68f7ef0-a2ff-4fa5-bbe8-5e21ba855ff6', NOW() - INTERVAL '2 days'),
('Thomas White', 4, 'Good food, friendly service. Will come back again!', 'b68f7ef0-a2ff-4fa5-bbe8-5e21ba855ff6', NOW() - INTERVAL '1 day');

-- Restaurant 5: Nasi Goreng Spesial (Medium rated - 3.7 stars)
INSERT INTO coments (name, rating, coments, restaurant_id, created_at) VALUES
('Nancy Harris', 4, 'Nasi gorengnya enak, bumbunya pas. Topping ayam dan telornya banyak.', '3a3a602f-8bd9-4065-a41f-4e69324a6eef', NOW() - INTERVAL '5 days'),
('Christopher Martin', 3, 'Standar sih, nothing special. Tapi dengan diskon masih oke lah.', '3a3a602f-8bd9-4065-a41f-4e69324a6eef', NOW() - INTERVAL '3 days'),
('Elizabeth Thompson', 4, 'Better than expected! Porsinya besar dan rasanya lumayan enak.', '3a3a602f-8bd9-4065-a41f-4e69324a6eef', NOW() - INTERVAL '2 days'),
('Alex Turner', 4, 'Good nasi goreng. Saya suka bumbu kecapnya yang manis gurih.', '3a3a602f-8bd9-4065-a41f-4e69324a6eef', NOW() - INTERVAL '1 day'),
('Olivia Parker', 3, 'Biasa aja. Agak keasinan menurut saya.', '3a3a602f-8bd9-4065-a41f-4e69324a6eef', NOW() - INTERVAL '12 hours');

-- =====================================================
-- ADDITIONAL DIVERSE COMMENTS
-- =====================================================

-- More reviews for better distribution
INSERT INTO coments (name, rating, coments, restaurant_id, created_at) VALUES
('William Clark', 5, 'Ayam bakarnya mantap! Sambalnya pedas dan enak. Highly recommended!', '14e0519d-170b-4838-a5c4-0734e9926c39', NOW() - INTERVAL '10 hours'),
('Sophia Lewis', 5, 'Soto Lamongan ter-enak! Kuahnya segar dan tidak amis. Love it!', 'b9b7550a-8487-4b84-bd1e-78c335be5fbe', NOW() - INTERVAL '6 hours'),
('Benjamin Walker', 4, 'Rendangnya authentic! Bumbunya kaya rempah traditional Padang.', '93b1b715-53c9-4505-8abd-fb611a7f5881', NOW() - INTERVAL '4 hours'),
('Ava Martinez', 5, 'Gulai ikannya fresh! Tidak amis sama sekali. Pelayanan juga ramah.', 'b68f7ef0-a2ff-4fa5-bbe8-5e21ba855ff6', NOW() - INTERVAL '2 hours'),
('Ethan Brown', 3, 'Nasi goreng biasa aja. Mungkin next time coba menu lain.', '3a3a602f-8bd9-4065-a41f-4e69324a6eef', NOW() - INTERVAL '1 hour');

-- =====================================================
-- VERIFICATION QUERY
-- =====================================================

-- After inserting, run this to verify:
/*
SELECT 
    r.id,
    r.food_name,
    r.food_type,
    COUNT(c.id) as total_reviews,
    ROUND(AVG(c.rating)::numeric, 1) as avg_rating
FROM restaurants r
LEFT JOIN coments c ON r.id = c.restaurant_id
WHERE r.id IN (
    '14e0519d-170b-4838-a5c4-0734e9926c39',
    'b9b7550a-8487-4b84-bd1e-78c335be5fbe',
    '93b1b715-53c9-4505-8abd-fb611a7f5881',
    'b68f7ef0-a2ff-4fa5-bbe8-5e21ba855ff6',
    '3a3a602f-8bd9-4065-a41f-4e69324a6eef'
)
GROUP BY r.id, r.food_name, r.food_type
ORDER BY avg_rating DESC;
*/

-- Expected Results:
-- 1. Rendang Daging Sapi: 5 reviews, avg 4.8 stars
-- 2. Ayam Bakar Madu: 5 reviews, avg 4.6 stars  
-- 3. Gulai Ikan Kakap: 5 reviews, avg 4.4 stars
-- 4. Soto Ayam Lamongan: 5 reviews, avg 4.0 stars
-- 5. Nasi Goreng Spesial: 5 reviews, avg 3.6 stars

-- =====================================================
-- END OF SAMPLE DATA SEEDER
-- =====================================================
