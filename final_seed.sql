-- 1. Ensure User Roles and initial users
INSERT INTO users (name, email, password, role, is_verified) 
VALUES 
('Admin User', 'admin@luxeestate.com', '$2y$12$GWTpJjXNEeJqBbaYVPB85eMjodbohAi/EoyAVQt1M60XxEbC4q3EW', 'admin', true),
('Marcus Chen', 'marcus@luxeestate.com', '$2y$12$GWTpJjXNEeJqBbaYVPB85eMjodbohAi/EoyAVQt1M60XxEbC4q3EW', 'agent', true),
('Julian Customer', 'julian@example.com', '$2y$12$GWTpJjXNEeJqBbaYVPB85eMjodbohAi/EoyAVQt1M60XxEbC4q3EW', 'customer', true)
ON CONFLICT (email) DO UPDATE SET role = EXCLUDED.role;

-- 2. Luxury Properties
INSERT INTO properties (owner_id, title, description, type, location, price, is_featured, listing_category, bhk_count, total_area, status)
SELECT id, 'The Obsidian Sanctuary', 'An architectural masterpiece of glass and steel.', 'Villa', 'Beverly Hills, CA', 24500000.00, true, 'buy', 6, 12500, 'active'
FROM users WHERE email = 'marcus@luxeestate.com'
ON CONFLICT DO NOTHING;

INSERT INTO properties (owner_id, title, description, type, location, price, is_featured, listing_category, bhk_count, total_area, status)
SELECT id, 'The Zenith Penthouse', 'Sky-high luxury with 360-degree views.', 'Penthouse', 'New York, NY', 18200000.00, true, 'buy', 4, 6200, 'active'
FROM users WHERE email = 'marcus@luxeestate.com'
ON CONFLICT DO NOTHING;

INSERT INTO properties (owner_id, title, description, type, location, price, is_featured, listing_category, bhk_count, total_area, status)
SELECT id, 'Marquina Villa', 'Minimalist design meets natural grandeur.', 'Villa', 'Bel Air, CA', 15750000.00, false, 'buy', 5, 8400, 'active'
FROM users WHERE email = 'marcus@luxeestate.com'
ON CONFLICT DO NOTHING;

-- 3. Dynamic Content (CMS)
INSERT INTO contents (title, slug, body, type)
VALUES 
('Investing in Architecture', 'investing-in-architecture', 'Luxury real estate is more than just square footage; it is an investment in architectural integrity...', 'guide'),
('The Future of Smart Homes', 'future-of-smart-homes', 'Integrating AI and sustainable energy into high-end residences...', 'blog')
ON CONFLICT (slug) DO NOTHING;
