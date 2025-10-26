-- =====================================================
-- REFOOD SAMPLE DATA SEEDER
-- Purpose: Populate database with realistic sample data
-- Date: 2025-10-26
-- =====================================================

-- Note: Run this AFTER running database_migration_script.sql
-- Make sure to replace UUIDs with actual restaurant IDs from your database

-- =====================================================
-- SAMPLE COMMENTS/REVIEWS DATA
-- =====================================================

-- First, get some restaurant IDs (you'll need to replace these with real IDs)
-- To get restaurant IDs, run: SELECT id, admin_id FROM restaurants LIMIT 5;

-- Example comments - Replace 'YOUR_RESTAURANT_ID_HERE' with actual UUIDs
-- Restaurant 1 - Highly rated (4.5 stars average)
INSERT INTO coments (name, rating, coments, restaurant_id, created_at) VALUES
('Sarah Johnson', 5, 'Amazing food and great service! The discount made it even better. Highly recommend!', 'YOUR_RESTAURANT_ID_1', NOW() - INTERVAL '5 days'),
('Michael Chen', 4, 'Good quality food. The portions are generous and the staff is friendly.', 'YOUR_RESTAURANT_ID_1', NOW() - INTERVAL '3 days'),
('Emma Williams', 5, 'Best Indonesian food I''ve had! The rendang was incredible.', 'YOUR_RESTAURANT_ID_1', NOW() - INTERVAL '2 days'),
('David Martinez', 4, 'Great value for money with the discount. Will definitely come back!', 'YOUR_RESTAURANT_ID_1', NOW() - INTERVAL '1 day');

-- Restaurant 2 - Medium rated (3.5 stars average)
INSERT INTO coments (name, rating, coments, restaurant_id, created_at) VALUES
('Lisa Anderson', 4, 'Nice ambiance and tasty food. Service could be faster though.', 'YOUR_RESTAURANT_ID_2', NOW() - INTERVAL '4 days'),
('James Wilson', 3, 'Food was okay, nothing special. The discount is the main reason to visit.', 'YOUR_RESTAURANT_ID_2', NOW() - INTERVAL '2 days'),
('Sophie Taylor', 4, 'Loved the pasta! Would recommend for a casual dinner.', 'YOUR_RESTAURANT_ID_2', NOW() - INTERVAL '1 day');

-- Restaurant 3 - Good rated (4.0 stars average)
INSERT INTO coments (name, rating, coments, restaurant_id, created_at) VALUES
('Robert Brown', 4, 'Solid Asian cuisine. The sushi was fresh and well-prepared.', 'YOUR_RESTAURANT_ID_3', NOW() - INTERVAL '6 days'),
('Amanda Garcia', 5, 'Excellent! The ramen was authentic and delicious.', 'YOUR_RESTAURANT_ID_3', NOW() - INTERVAL '3 days'),
('Kevin Lee', 3, 'Decent food but a bit pricey even with discount.', 'YOUR_RESTAURANT_ID_3', NOW() - INTERVAL '1 day'),
('Maria Rodriguez', 4, 'Great experience overall. Would come again!', 'YOUR_RESTAURANT_ID_3', NOW() - INTERVAL '8 hours');

-- Restaurant 4 - Excellent rated (4.8 stars)
INSERT INTO coments (name, rating, coments, restaurant_id, created_at) VALUES
('John Smith', 5, 'Outstanding! Best burger in town. The discount is just a bonus.', 'YOUR_RESTAURANT_ID_4', NOW() - INTERVAL '7 days'),
('Patricia Davis', 5, 'Absolutely loved it! Will bring my family next time.', 'YOUR_RESTAURANT_ID_4', NOW() - INTERVAL '4 days'),
('Daniel Kim', 5, 'Perfect! Food, service, ambiance - everything was great.', 'YOUR_RESTAURANT_ID_4', NOW() - INTERVAL '2 days'),
('Jennifer Lopez', 4, 'Very good food. Slightly crowded but worth the wait.', 'YOUR_RESTAURANT_ID_4', NOW() - INTERVAL '1 day');

-- Restaurant 5 - Lower rated (3.0 stars)
INSERT INTO coments (name, rating, coments, restaurant_id, created_at) VALUES
('Thomas White', 3, 'Average food. The service needs improvement.', 'YOUR_RESTAURANT_ID_5', NOW() - INTERVAL '5 days'),
('Nancy Harris', 3, 'It''s okay for the price with discount. Nothing memorable.', 'YOUR_RESTAURANT_ID_5', NOW() - INTERVAL '2 days'),
('Christopher Martin', 2, 'Disappointed. Food was cold when served.', 'YOUR_RESTAURANT_ID_5', NOW() - INTERVAL '1 day'),
('Elizabeth Thompson', 4, 'Better than expected! Give it a try.', 'YOUR_RESTAURANT_ID_5', NOW() - INTERVAL '12 hours');

-- =====================================================
-- HOW TO USE THIS SEEDER
-- =====================================================

-- STEP 1: Get your actual restaurant IDs
-- Run this query in Supabase SQL Editor:
-- SELECT id, food_type FROM restaurants ORDER BY created_at LIMIT 10;

-- STEP 2: Replace all 'YOUR_RESTAURANT_ID_X' with actual UUIDs
-- Example: Replace 'YOUR_RESTAURANT_ID_1' with 'a1b2c3d4-5678-90ab-cdef-123456789abc'

-- STEP 3: Run the INSERT statements one by one or all at once

-- STEP 4: Verify the data
-- SELECT 
--     r.id,
--     r.food_name,
--     COUNT(c.id) as total_reviews,
--     ROUND(AVG(c.rating)::numeric, 1) as avg_rating
-- FROM restaurants r
-- LEFT JOIN coments c ON r.id = c.restaurant_id
-- GROUP BY r.id, r.food_name
-- ORDER BY avg_rating DESC NULLS LAST;

-- =====================================================
-- ADDITIONAL SAMPLE DATA (Optional)
-- =====================================================

-- More diverse comments for better testing
-- Add these after you've added the first batch

-- Mixed ratings for realistic data
INSERT INTO coments (name, rating, coments, restaurant_id, created_at) VALUES
('Alex Turner', 5, 'Fantastic experience! The chef really knows their craft.', 'YOUR_RESTAURANT_ID_1', NOW() - INTERVAL '10 hours'),
('Olivia Parker', 1, 'Very disappointing. Won''t be coming back.', 'YOUR_RESTAURANT_ID_5', NOW() - INTERVAL '6 hours'),
('William Clark', 4, 'Great food, friendly staff. Recommended!', 'YOUR_RESTAURANT_ID_2', NOW() - INTERVAL '4 hours'),
('Sophia Lewis', 5, 'Best meal I''ve had in months! Worth every penny.', 'YOUR_RESTAURANT_ID_4', NOW() - INTERVAL '2 hours'),
('Benjamin Walker', 3, 'It''s alright. Nothing to write home about.', 'YOUR_RESTAURANT_ID_3', NOW() - INTERVAL '1 hour');

-- =====================================================
-- VERIFICATION QUERIES
-- =====================================================

-- Check total comments per restaurant
-- SELECT 
--     restaurant_id, 
--     COUNT(*) as total_comments 
-- FROM coments 
-- GROUP BY restaurant_id;

-- Check rating distribution
-- SELECT 
--     rating, 
--     COUNT(*) as count 
-- FROM coments 
-- GROUP BY rating 
-- ORDER BY rating DESC;

-- Get restaurants with their stats
-- SELECT 
--     r.id,
--     r.food_name,
--     r.food_type,
--     r.discount_percentage,
--     COUNT(c.id) as total_reviews,
--     ROUND(AVG(c.rating)::numeric, 2) as avg_rating,
--     MIN(c.rating) as min_rating,
--     MAX(c.rating) as max_rating
-- FROM restaurants r
-- LEFT JOIN coments c ON r.id = c.restaurant_id
-- GROUP BY r.id, r.food_name, r.food_type, r.discount_percentage
-- ORDER BY avg_rating DESC NULLS LAST;

-- =====================================================
-- END OF SAMPLE DATA SEEDER
-- =====================================================
