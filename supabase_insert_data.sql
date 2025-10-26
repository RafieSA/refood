-- =====================================================
-- REFOOD - INSERT SAMPLE DATA FOR SUPABASE
-- =====================================================
-- Copy-paste file ini ke SQL Editor di Supabase
-- dan jalankan untuk mengisi database dengan data sample
-- =====================================================

-- =====================================================
-- 1. INSERT SUPER ADMIN
-- =====================================================
-- Password: admin123
INSERT INTO super_admins (id, name, email, password, created_at, updated_at)
VALUES 
(uuid_generate_v4(), 'Super Admin', 'superadmin@refood.com', '$2y$12$LQv3c1yduTI6.o8B/oj.fOXEXl1r6jOvZq7F3VqN3xqCQZ9lE8ZkW', NOW(), NOW())
ON CONFLICT (email) DO NOTHING;

-- =====================================================
-- 2. INSERT ADMINS (Restaurant Owners)
-- =====================================================
-- Password untuk semua admin: resto123
INSERT INTO admins (id, email, password, "Restaurant_Name", created_at, updated_at)
VALUES 
('11111111-1111-1111-1111-111111111111', 'admin.warungmakan@gmail.com', '$2y$12$LQv3c1yduTI6.o8B/oj.fOXEXl1r6jOvZq7F3VqN3xqCQZ9lE8ZkW', 'Warung Makan Sederhana', NOW(), NOW()),
('22222222-2222-2222-2222-222222222222', 'admin.padangasli@gmail.com', '$2y$12$LQv3c1yduTI6.o8B/oj.fOXEXl1r6jOvZq7F3VqN3xqCQZ9lE8ZkW', 'Rumah Makan Padang Asli', NOW(), NOW()),
('33333333-3333-3333-3333-333333333333', 'admin.bakerymanis@gmail.com', '$2y$12$LQv3c1yduTI6.o8B/oj.fOXEXl1r6jOvZq7F3VqN3xqCQZ9lE8ZkW', 'Bakery Manis Bandung', NOW(), NOW()),
('44444444-4444-4444-4444-444444444444', 'admin.seafoodbahari@gmail.com', '$2y$12$LQv3c1yduTI6.o8B/oj.fOXEXl1r6jOvZq7F3VqN3xqCQZ9lE8ZkW', 'Seafood Bahari', NOW(), NOW()),
('55555555-5555-5555-5555-555555555555', 'admin.pizzaitalia@gmail.com', '$2y$12$LQv3c1yduTI6.o8B/oj.fOXEXl1r6jOvZq7F3VqN3xqCQZ9lE8ZkW', 'Pizza Italia Jakarta', NOW(), NOW())
ON CONFLICT (email) DO NOTHING;

-- =====================================================
-- 3. INSERT RESTAURANTS (Menus dengan Diskon)
-- =====================================================
-- Note: Kolom 'name' dan 'address' dihapus karena info restoran ada di tabel admins
INSERT INTO restaurants (id, admin_id, address, food_name, food_type, discount_percentage, discount_duration_hours, discount, photo_url, opening_hours, created_at)
VALUES 
-- Warung Makan Sederhana
(uuid_generate_v4(), '11111111-1111-1111-1111-111111111111', 'Jl. Sudirman No. 45, Jakarta Pusat', 'Nasi Goreng Spesial', 'Indonesian', 30, 3, 15000, 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=400', '08:00 - 22:00', NOW()),
(uuid_generate_v4(), '11111111-1111-1111-1111-111111111111', 'Jl. Sudirman No. 45, Jakarta Pusat', 'Ayam Bakar Madu', 'Indonesian', 25, 2, 22500, 'https://images.unsplash.com/photo-1598103442097-8b74394b95c6?w=400', '08:00 - 22:00', NOW()),
(uuid_generate_v4(), '11111111-1111-1111-1111-111111111111', 'Jl. Sudirman No. 45, Jakarta Pusat', 'Soto Ayam Lamongan', 'Indonesian', 20, 4, 12000, 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=400', '08:00 - 22:00', NOW()),

-- Rumah Makan Padang Asli  
(uuid_generate_v4(), '22222222-2222-2222-2222-222222222222', 'Jl. Gatot Subroto No. 128, Bandung', 'Rendang Daging Sapi', 'Indonesian', 35, 2, 32500, 'https://images.unsplash.com/photo-1562967914-608f82629710?w=400', '09:00 - 21:00', NOW()),
(uuid_generate_v4(), '22222222-2222-2222-2222-222222222222', 'Jl. Gatot Subroto No. 128, Bandung', 'Gulai Ikan Kakap', 'Indonesian', 30, 3, 28000, 'https://images.unsplash.com/photo-1580959375944-0b1b7f3c5c5b?w=400', '09:00 - 21:00', NOW()),
(uuid_generate_v4(), '22222222-2222-2222-2222-222222222222', 'Jl. Gatot Subroto No. 128, Bandung', 'Ayam Pop Khas Padang', 'Indonesian', 25, 2, 21000, 'https://images.unsplash.com/photo-1587593810167-a84920ea0781?w=400', '09:00 - 21:00', NOW()),

-- Bakery Manis Bandung
(uuid_generate_v4(), '33333333-3333-3333-3333-333333333333', 'Jl. Dago No. 88, Bandung', 'Roti Croissant Butter', 'Bakery', 40, 5, 18000, 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=400', '06:00 - 20:00', NOW()),
(uuid_generate_v4(), '33333333-3333-3333-3333-333333333333', 'Jl. Dago No. 88, Bandung', 'Kue Brownies Coklat', 'Bakery', 35, 4, 19500, 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400', '06:00 - 20:00', NOW()),
(uuid_generate_v4(), '33333333-3333-3333-3333-333333333333', 'Jl. Dago No. 88, Bandung', 'Donut Strawberry', 'Bakery', 50, 6, 10000, 'https://images.unsplash.com/photo-1551024506-0bccd828d307?w=400', '06:00 - 20:00', NOW()),

-- Seafood Bahari
(uuid_generate_v4(), '44444444-4444-4444-4444-444444444444', 'Jl. Pantai Indah No. 22, Surabaya', 'Udang Bakar Jumbo', 'Seafood', 30, 3, 70000, 'https://images.unsplash.com/photo-1559847844-d9710c7c7f08?w=400', '10:00 - 23:00', NOW()),
(uuid_generate_v4(), '44444444-4444-4444-4444-444444444444', 'Jl. Pantai Indah No. 22, Surabaya', 'Cumi Saus Padang', 'Seafood', 25, 2, 52500, 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=400', '10:00 - 23:00', NOW()),
(uuid_generate_v4(), '44444444-4444-4444-4444-444444444444', 'Jl. Pantai Indah No. 22, Surabaya', 'Kepiting Soka Goreng', 'Seafood', 20, 4, 80000, 'https://images.unsplash.com/photo-1580959375944-0b1b7f3c5c5b?w=400', '10:00 - 23:00', NOW()),

-- Pizza Italia Jakarta
(uuid_generate_v4(), '55555555-5555-5555-5555-555555555555', 'Jl. Senopati No. 77, Jakarta Selatan', 'Pizza Margherita', 'Italian', 30, 2, 52500, 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=400', '11:00 - 22:00', NOW()),
(uuid_generate_v4(), '55555555-5555-5555-5555-555555555555', 'Jl. Senopati No. 77, Jakarta Selatan', 'Spaghetti Carbonara', 'Italian', 25, 3, 45000, 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=400', '11:00 - 22:00', NOW()),
(uuid_generate_v4(), '55555555-5555-5555-5555-555555555555', 'Jl. Senopati No. 77, Jakarta Selatan', 'Lasagna Bolognese', 'Italian', 35, 2, 39000, 'https://images.unsplash.com/photo-1574894709920-11b28e7367e3?w=400', '11:00 - 22:00', NOW());

-- =====================================================
-- 4. INSERT USERS (Regular Customers)
-- =====================================================
-- Password untuk semua user: user123
INSERT INTO users (name, email, password, email_verified_at, created_at, updated_at)
VALUES 
('Budi Santoso', 'budi.santoso@gmail.com', '$2y$12$LQv3c1yduTI6.o8B/oj.fOXEXl1r6jOvZq7F3VqN3xqCQZ9lE8ZkW', NOW(), NOW(), NOW()),
('Siti Nurhaliza', 'siti.nurhaliza@gmail.com', '$2y$12$LQv3c1yduTI6.o8B/oj.fOXEXl1r6jOvZq7F3VqN3xqCQZ9lE8ZkW', NOW(), NOW(), NOW()),
('Agus Wijaya', 'agus.wijaya@yahoo.com', '$2y$12$LQv3c1yduTI6.o8B/oj.fOXEXl1r6jOvZq7F3VqN3xqCQZ9lE8ZkW', NOW(), NOW(), NOW()),
('Dewi Lestari', 'dewi.lestari@outlook.com', '$2y$12$LQv3c1yduTI6.o8B/oj.fOXEXl1r6jOvZq7F3VqN3xqCQZ9lE8ZkW', NOW(), NOW(), NOW()),
('Rudi Hermawan', 'rudi.hermawan@gmail.com', '$2y$12$LQv3c1yduTI6.o8B/oj.fOXEXl1r6jOvZq7F3VqN3xqCQZ9lE8ZkW', NOW(), NOW(), NOW())
ON CONFLICT (email) DO NOTHING;

-- =====================================================
-- 5. INSERT ARTICLES (Blog/News)
-- =====================================================
INSERT INTO articles (id, title, description, image_url, uploaded_at, created_at, updated_at)
VALUES 
(uuid_generate_v4(), 'Tips Mengurangi Food Waste di Rumah', 'Pelajari cara-cara sederhana untuk mengurangi pemborosan makanan di rumah dan berkontribusi pada lingkungan yang lebih baik.', 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=600', NOW(), NOW(), NOW()),
(uuid_generate_v4(), 'Manfaat Donasi Makanan untuk Masyarakat', 'Mendonasikan makanan berlebih tidak hanya membantu yang membutuhkan, tetapi juga mengurangi sampah organik.', 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=600', NOW(), NOW(), NOW()),
(uuid_generate_v4(), '5 Restoran di Jakarta yang Mendukung Zero Waste', 'Daftar restoran di Jakarta yang aktif menerapkan konsep zero waste dan sustainability dalam operasional mereka.', 'https://images.unsplash.com/photo-1552566626-52f8b828add9?w=600', NOW(), NOW(), NOW()),
(uuid_generate_v4(), 'Cara Menyimpan Makanan Agar Lebih Tahan Lama', 'Teknik penyimpanan makanan yang tepat dapat memperpanjang masa simpan dan mengurangi food waste.', 'https://images.unsplash.com/photo-1584308972272-9e4e7685e80f?w=600', NOW(), NOW(), NOW()),
(uuid_generate_v4(), 'Program Refood: Menyelamatkan Makanan, Menyelamatkan Bumi', 'Bagaimana program Refood membantu restoran dan konsumen untuk mengurangi food waste secara masif.', 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=600', NOW(), NOW(), NOW());

-- =====================================================
-- 6. INSERT COMMENTS (Reviews)
-- =====================================================
INSERT INTO coments (name, rating, coments)
VALUES 
('Budi Santoso', 5, 'Aplikasi yang sangat membantu! Saya bisa mendapatkan makanan berkualitas dengan harga diskon. Terima kasih Refood!'),
('Siti Nurhaliza', 4, 'Konsep yang bagus untuk mengurangi food waste. Pilihan restorannya juga beragam.'),
('Agus Wijaya', 5, 'Mantap! Bisa hemat dan tetap makan enak. Aplikasi yang sangat recommended!'),
('Dewi Lestari', 4, 'Sangat membantu untuk yang ingin makan enak tapi budget terbatas. Semoga semakin banyak resto yang join.'),
('Rudi Hermawan', 5, 'Perfect solution untuk food waste problem. Interface-nya juga user friendly!'),
('Maya Putri', 3, 'Bagus sih, tapi kadang diskonnya cepat habis. Mungkin bisa ditambah kuota diskonnya.'),
('Andi Pratama', 5, 'Aplikasi keren! Selain hemat, juga ikut peduli lingkungan. Two thumbs up!'),
('Linda Kusuma', 4, 'Senang bisa berkontribusi mengurangi sampah makanan sambil menikmati hidangan lezat.');

-- =====================================================
-- 7. VERIFICATION QUERY
-- =====================================================
-- Jalankan query ini untuk memverifikasi data berhasil diinsert
SELECT 'Super Admins' as table_name, COUNT(*) as total FROM super_admins
UNION ALL
SELECT 'Admins', COUNT(*) FROM admins
UNION ALL
SELECT 'Restaurants', COUNT(*) FROM restaurants
UNION ALL
SELECT 'Users', COUNT(*) FROM users
UNION ALL
SELECT 'Articles', COUNT(*) FROM articles
UNION ALL
SELECT 'Comments', COUNT(*) FROM coments
ORDER BY table_name;

-- =====================================================
-- CREDENTIAL INFO
-- =====================================================
-- Super Admin Login:
--   Email: superadmin@refood.com
--   Password: admin123

-- Admin Resto Login (password semua sama: resto123):
--   1. admin.warungmakan@gmail.com
--   2. admin.padangasli@gmail.com
--   3. admin.bakerymanis@gmail.com
--   4. admin.seafoodbahari@gmail.com
--   5. admin.pizzaitalia@gmail.com

-- User Login (password semua sama: user123):
--   1. budi.santoso@gmail.com
--   2. siti.nurhaliza@gmail.com
--   3. agus.wijaya@yahoo.com
--   4. dewi.lestari@outlook.com
--   5. rudi.hermawan@gmail.com
