-- Initial Users
INSERT INTO users (name, email, password, role, is_verified) 
VALUES 
('Admin User', 'admin@luxeestate.com', '$2y$12$GWTpJjXNEeJqBbaYVPB85eMjodbohAi/EoyAVQt1M60XxEbC4q3EW', 'admin', true),
('Marcus Chen', 'marcus@luxeestate.com', '$2y$12$GWTpJjXNEeJqBbaYVPB85eMjodbohAi/EoyAVQt1M60XxEbC4q3EW', 'agent', true),
('Julian', 'julian@example.com', '$2y$12$GWTpJjXNEeJqBbaYVPB85eMjodbohAi/EoyAVQt1M60XxEbC4q3EW', 'customer', true)
ON CONFLICT (email) DO NOTHING;

-- Initial Properties
INSERT INTO properties (owner_id, title, description, type, location, price, is_featured, listing_category, bhk_count, total_area)
SELECT id, 'The Obsidian Sanctuary', 'An architectural masterpiece of glass and steel.', 'Villa', 'Beverly Hills, CA', 24500000.00, true, 'buy', 6, 12500
FROM users WHERE email = 'marcus@luxeestate.com'
LIMIT 1;

INSERT INTO properties (owner_id, title, description, type, location, price, is_featured, listing_category, bhk_count, total_area)
SELECT id, 'The Zenith Penthouse', 'Sky-high luxury with 360-degree views.', 'Penthouse', 'New York, NY', 18200000.00, true, 'buy', 4, 6200
FROM users WHERE email = 'marcus@luxeestate.com'
LIMIT 1;
