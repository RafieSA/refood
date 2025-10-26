-- =====================================================
-- DATABASE INDEXING OPTIMIZATION - REFOOD
-- Generated: 2025-10-26
-- Purpose: Add indexes for better query performance
-- =====================================================

-- =====================================================
-- EXISTING INDEXES (Already created in migration)
-- =====================================================
-- ✅ idx_coments_restaurant_id ON coments(restaurant_id)
-- ✅ Primary keys on all tables (id columns)
-- ✅ Foreign keys with ON DELETE CASCADE

-- =====================================================
-- RECOMMENDED NEW INDEXES FOR PERFORMANCE
-- =====================================================

-- 1. INDEX FOR RESTAURANT SEARCH (food_name, restaurant_name, food_type)
-- Used by: search functionality in index page
-- Benefit: Speeds up LIKE queries
CREATE INDEX IF NOT EXISTS idx_restaurants_search ON restaurants(food_name, restaurant_name, food_type);

-- 2. INDEX FOR RESTAURANT FILTERING (food_type)
-- Used by: category filter
-- Benefit: Faster WHERE food_type = 'X' queries
CREATE INDEX IF NOT EXISTS idx_restaurants_food_type ON restaurants(food_type);

-- 3. INDEX FOR DISCOUNT FILTERING (discount_percentage)
-- Used by: discount filter
-- Benefit: Faster WHERE discount_percentage >= X queries
CREATE INDEX IF NOT EXISTS idx_restaurants_discount ON restaurants(discount_percentage);

-- 4. INDEX FOR COMMENT RATING (rating, created_at)
-- Used by: sorting comments by rating and date
-- Benefit: Faster ORDER BY rating, created_at queries
CREATE INDEX IF NOT EXISTS idx_coments_rating_date ON coments(rating DESC, created_at DESC);

-- 5. INDEX FOR COMMENT DATE SORTING (created_at)
-- Used by: sorting comments by newest/oldest
-- Benefit: Faster ORDER BY created_at queries
CREATE INDEX IF NOT EXISTS idx_coments_created_at ON coments(created_at DESC);

-- 6. COMPOSITE INDEX FOR RESTAURANT + RATING
-- Used by: calculating average rating per restaurant
-- Benefit: Speeds up AVG(rating) WHERE restaurant_id = X
CREATE INDEX IF NOT EXISTS idx_coments_restaurant_rating ON coments(restaurant_id, rating);

-- 7. INDEX FOR ADMIN LOOKUP (admin_id)
-- Used by: joining restaurants with admins
-- Benefit: Faster admin lookup
CREATE INDEX IF NOT EXISTS idx_restaurants_admin_id ON restaurants(admin_id);

-- 8. TEXT SEARCH INDEX (PostgreSQL Full-Text Search)
-- Used by: advanced search functionality
-- Benefit: Much faster text search
CREATE INDEX IF NOT EXISTS idx_restaurants_fulltext_search ON restaurants 
USING gin(to_tsvector('english', food_name || ' ' || restaurant_name || ' ' || COALESCE(food_type, '')));

-- =====================================================
-- OPTIONAL: Update table statistics for better query planning
-- =====================================================
-- Run these periodically for optimal performance
ANALYZE restaurants;
ANALYZE coments;
ANALYZE admins;

-- =====================================================
-- VERIFY INDEXES
-- =====================================================
-- Run this to see all indexes on restaurants table:
-- SELECT * FROM pg_indexes WHERE tablename = 'restaurants';

-- Run this to see all indexes on coments table:
-- SELECT * FROM pg_indexes WHERE tablename = 'coments';

-- =====================================================
-- PERFORMANCE MONITORING QUERIES
-- =====================================================

-- 1. Check which indexes are being used
-- SELECT schemaname, tablename, indexname, idx_scan, idx_tup_read, idx_tup_fetch
-- FROM pg_stat_user_indexes
-- ORDER BY idx_scan DESC;

-- 2. Check table sizes
-- SELECT 
--     tablename,
--     pg_size_pretty(pg_total_relation_size(schemaname||'.'||tablename)) AS size
-- FROM pg_tables
-- WHERE schemaname = 'public'
-- ORDER BY pg_total_relation_size(schemaname||'.'||tablename) DESC;

-- 3. Check slow queries (requires pg_stat_statements extension)
-- SELECT query, mean_exec_time, calls 
-- FROM pg_stat_statements 
-- ORDER BY mean_exec_time DESC 
-- LIMIT 10;

-- =====================================================
-- NOTES & BEST PRACTICES
-- =====================================================
-- 1. Too many indexes can slow down INSERT/UPDATE operations
-- 2. Only create indexes on columns used in WHERE, ORDER BY, JOIN clauses
-- 3. Composite indexes should put most selective columns first
-- 4. Monitor index usage with pg_stat_user_indexes
-- 5. Remove unused indexes periodically
-- 6. Run ANALYZE regularly to update statistics
-- 7. Consider partial indexes for frequently filtered data

-- =====================================================
-- ROLLBACK SCRIPT (if needed)
-- =====================================================
/*
DROP INDEX IF EXISTS idx_restaurants_search;
DROP INDEX IF EXISTS idx_restaurants_food_type;
DROP INDEX IF EXISTS idx_restaurants_discount;
DROP INDEX IF EXISTS idx_coments_rating_date;
DROP INDEX IF EXISTS idx_coments_created_at;
DROP INDEX IF EXISTS idx_coments_restaurant_rating;
DROP INDEX IF EXISTS idx_restaurants_admin_id;
DROP INDEX IF EXISTS idx_restaurants_fulltext_search;
*/
