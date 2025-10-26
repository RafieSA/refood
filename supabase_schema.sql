-- =====================================================
-- REFOOD DATABASE SCHEMA FOR SUPABASE (PostgreSQL)
-- =====================================================
-- Generated for Rafie's portfolio project
-- Date: 2025-10-24
-- =====================================================

-- Enable UUID extension
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- =====================================================
-- 1. USERS TABLE
-- =====================================================
-- Standard Laravel user authentication table
CREATE TABLE IF NOT EXISTS users (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================================================
-- 2. ADMINS TABLE
-- =====================================================
-- Restaurant admin accounts (uses UUID)
CREATE TABLE IF NOT EXISTS admins (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    Restaurant_Name VARCHAR(255) NULL,
    Restaurant_Photo VARCHAR(255) NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================================================
-- 3. SUPER_ADMINS TABLE
-- =====================================================
-- Super admin accounts with full system access (uses UUID)
CREATE TABLE IF NOT EXISTS super_admins (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================================================
-- 4. RESTAURANTS TABLE
-- =====================================================
-- Restaurant information and discount details (uses UUID)
CREATE TABLE IF NOT EXISTS restaurants (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    admin_id UUID NOT NULL,
    name VARCHAR(255) NULL,
    address TEXT NULL,
    food_name VARCHAR(255) NULL,
    food_type VARCHAR(100) NULL,
    discount_percentage INTEGER NULL,
    discount_duration_hours INTEGER NULL,
    discount DECIMAL(10, 2) NULL,
    photo_url TEXT NULL,
    opening_hours VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_admin FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE CASCADE
);

-- Index for faster queries on admin_id and food_type
CREATE INDEX IF NOT EXISTS idx_restaurants_admin_id ON restaurants(admin_id);
CREATE INDEX IF NOT EXISTS idx_restaurants_food_type ON restaurants(food_type);

-- =====================================================
-- 5. ARTICLES TABLE
-- =====================================================
-- News/blog articles (uses UUID)
CREATE TABLE IF NOT EXISTS articles (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    image_url TEXT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index for ordering by upload date
CREATE INDEX IF NOT EXISTS idx_articles_uploaded_at ON articles(uploaded_at DESC);

-- =====================================================
-- 6. COMENTS TABLE (typo preserved from original)
-- =====================================================
-- User comments/reviews
CREATE TABLE IF NOT EXISTS coments (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    rating INTEGER NOT NULL CHECK (rating >= 1 AND rating <= 5),
    coments TEXT NOT NULL
);

-- =====================================================
-- 7. DISCOUNT_CLAIMS TABLE
-- =====================================================
-- Discount claim requests from users
CREATE TABLE IF NOT EXISTS discount_claims (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    restaurant_id UUID NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    notes TEXT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    claim_code VARCHAR(50) UNIQUE NOT NULL,
    expire_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_restaurant FOREIGN KEY (restaurant_id) REFERENCES restaurants(id) ON DELETE CASCADE
);

-- Indexes for faster queries
CREATE INDEX IF NOT EXISTS idx_discount_claims_restaurant_id ON discount_claims(restaurant_id);
CREATE INDEX IF NOT EXISTS idx_discount_claims_status ON discount_claims(status);
CREATE INDEX IF NOT EXISTS idx_discount_claims_claim_code ON discount_claims(claim_code);

-- =====================================================
-- 8. MIGRATIONS TABLE (Laravel migrations tracking)
-- =====================================================
CREATE TABLE IF NOT EXISTS migrations (
    id SERIAL PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch INTEGER NOT NULL
);

-- =====================================================
-- INITIAL DATA (Optional - Super Admin Seeder)
-- =====================================================
-- Insert default super admin account
-- Password: 12345678 (hashed with bcrypt)
INSERT INTO super_admins (id, name, email, password, created_at, updated_at)
VALUES (
    uuid_generate_v4(),
    'Super Admin',
    'superadmin@example.com',
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- bcrypt hash of "12345678"
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
)
ON CONFLICT (email) DO NOTHING;

-- =====================================================
-- ROW LEVEL SECURITY (RLS) POLICIES
-- =====================================================
-- Enable RLS on all tables
ALTER TABLE users ENABLE ROW LEVEL SECURITY;
ALTER TABLE admins ENABLE ROW LEVEL SECURITY;
ALTER TABLE super_admins ENABLE ROW LEVEL SECURITY;
ALTER TABLE restaurants ENABLE ROW LEVEL SECURITY;
ALTER TABLE articles ENABLE ROW LEVEL SECURITY;
ALTER TABLE coments ENABLE ROW LEVEL SECURITY;
ALTER TABLE discount_claims ENABLE ROW LEVEL SECURITY;

-- Public read access for restaurants and articles
CREATE POLICY "Public restaurants read" ON restaurants FOR SELECT USING (true);
CREATE POLICY "Public articles read" ON articles FOR SELECT USING (true);
CREATE POLICY "Public coments read" ON coments FOR SELECT USING (true);

-- Admins can manage their own restaurants
CREATE POLICY "Admins manage own restaurants" ON restaurants 
FOR ALL USING (auth.uid()::text = admin_id::text);

-- Public can insert discount claims
CREATE POLICY "Public discount claims insert" ON discount_claims 
FOR INSERT WITH CHECK (true);

-- Public can insert comments
CREATE POLICY "Public coments insert" ON coments 
FOR INSERT WITH CHECK (true);

-- =====================================================
-- FUNCTIONS FOR AUTO-UPDATING updated_at
-- =====================================================
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Apply triggers to tables with updated_at
CREATE TRIGGER update_users_updated_at BEFORE UPDATE ON users 
FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_admins_updated_at BEFORE UPDATE ON admins 
FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_super_admins_updated_at BEFORE UPDATE ON super_admins 
FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_articles_updated_at BEFORE UPDATE ON articles 
FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_discount_claims_updated_at BEFORE UPDATE ON discount_claims 
FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

-- =====================================================
-- END OF SCHEMA
-- =====================================================
