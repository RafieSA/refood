-- =====================================================
-- REFOOD DATABASE MIGRATION SCRIPT
-- Purpose: Fix hardcode issues and add dynamic features
-- Date: 2025-10-26
-- =====================================================

-- =====================================================
-- STEP 1: ADD restaurant_id TO coments TABLE
-- =====================================================

-- Check if column already exists (skip if exists)
-- Note: Run this in Supabase SQL Editor

-- Add restaurant_id column (allowing NULL temporarily for existing data)
ALTER TABLE coments 
ADD COLUMN IF NOT EXISTS restaurant_id UUID;

-- Update existing comments (if any) - set to first restaurant as default
-- You may want to delete existing test data instead
-- UPDATE coments SET restaurant_id = (SELECT id FROM restaurants LIMIT 1) WHERE restaurant_id IS NULL;

-- Make restaurant_id NOT NULL after data migration
-- ALTER TABLE coments ALTER COLUMN restaurant_id SET NOT NULL;

-- Add foreign key constraint
ALTER TABLE coments
ADD CONSTRAINT fk_coments_restaurant 
FOREIGN KEY (restaurant_id) REFERENCES restaurants(id) ON DELETE CASCADE;

-- Add index for faster queries
CREATE INDEX IF NOT EXISTS idx_coments_restaurant_id ON coments(restaurant_id);

-- Add created_at column if not exists
ALTER TABLE coments 
ADD COLUMN IF NOT EXISTS created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

-- =====================================================
-- STEP 2: CREATE food_categories TABLE
-- =====================================================

CREATE TABLE IF NOT EXISTS food_categories (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    icon VARCHAR(10) NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert initial category data
INSERT INTO food_categories (name, slug, icon, description) VALUES
    ('Indonesian', 'indonesian', '🍚', 'Traditional Indonesian cuisine'),
    ('Western', 'western', '🍔', 'Western-style dishes'),
    ('Asian', 'asian', '🍣', 'Various Asian cuisines')
ON CONFLICT (name) DO NOTHING;

-- =====================================================
-- STEP 3: ADD TRIGGER FOR updated_at ON food_categories
-- =====================================================

CREATE TRIGGER update_food_categories_updated_at 
BEFORE UPDATE ON food_categories 
FOR EACH ROW 
EXECUTE FUNCTION update_updated_at_column();

-- =====================================================
-- VERIFICATION QUERIES
-- =====================================================

-- Check coments table structure
-- SELECT column_name, data_type, is_nullable 
-- FROM information_schema.columns 
-- WHERE table_name = 'coments';

-- Check food_categories data
-- SELECT * FROM food_categories;

-- Check restaurants by category
-- SELECT food_type, COUNT(*) as total 
-- FROM restaurants 
-- GROUP BY food_type;

-- =====================================================
-- ROLLBACK SCRIPT (if needed)
-- =====================================================

-- To rollback changes:
-- DROP INDEX IF EXISTS idx_coments_restaurant_id;
-- ALTER TABLE coments DROP CONSTRAINT IF EXISTS fk_coments_restaurant;
-- ALTER TABLE coments DROP COLUMN IF EXISTS restaurant_id;
-- DROP TABLE IF EXISTS food_categories;

-- =====================================================
-- END OF MIGRATION SCRIPT
-- =====================================================
