-- Sample Data for Lavender Pharmacy

-- Insert Categories
INSERT INTO categories (category_name, description) VALUES
('Pain Relief', 'Pain and headache relievers'),
('Cold & Cough', 'Cold, cough, and flu medications'),
('Vitamins & Supplements', 'Vitamins and dietary supplements'),
('Antacids', 'Stomach and digestive aids'),
('Antihistamines', 'Allergy and antihistamine products'),
('Antibiotics', 'Antibiotic medications'),
('Topical', 'Creams, ointments, and external medicines');

-- Insert Products
INSERT INTO products (product_name, generic_name, brand_name, category_id, description, dosage_info, price, stock_quantity, expiration_date, manufacturer, barcode, prescription_required) VALUES

-- Pain Relief
('Biogesic Paracetamol 500mg', 'Paracetamol', 'Biogesic', 1, 'Effective pain reliever and fever reducer', '500mg tablet', 9.99, 150, '2026-12-31', 'Upsher-Smith', '4800009012345', 0),

-- Cold & Cough
('Neozep Cold & Cough', 'Phenylpropanolamine', 'Neozep', 2, 'Relieves cold and cough symptoms', '1 capsule every 12 hours', 8.50, 120, '2026-11-30', 'Merck', '4800009012346', 0),
('Bioflu Flu Tablet', 'Paracetamol + Phenylpropanolamine', 'Bioflu', 2, 'Treats flu symptoms effectively', '1 tablet every 6 hours', 10.99, 200, '2026-10-31', 'Sterling', '4800009012347', 0),
('Decolgen Tablet', 'Paracetamol + Phenylpropanolamine + Caffeine', 'Decolgen', 2, 'Fast-acting cold and flu reliever', '1-2 tablets every 4-6 hours', 12.50, 100, '2026-09-30', 'Merck', '4800009012348', 0),

-- Vitamins & Supplements
('Enervon Vitamin C', 'Ascorbic Acid', 'Enervon', 3, 'Immune system booster', '1 tablet daily', 15.99, 250, '2027-06-30', 'Merck', '4800009012349', 0),
('Solmux Tablet', 'Ambroxol', 'Solmux', 2, 'Cough expectorant', '1 tablet 3 times daily', 11.50, 80, '2026-08-31', 'Boehringer Ingelheim', '4800009012350', 0),

-- Antacids
('Kremil-S Antacid', 'Aluminum & Magnesium Hydroxide', 'Kremil-S', 4, 'Quick relief from heartburn', '2 tablets when needed', 7.99, 175, '2026-12-31', 'Alza', '4800009012351', 0),

-- Antibiotics
('Amoxicillin 500mg', 'Amoxicillin', 'Generic', 6, 'Broad-spectrum antibiotic', '1 capsule 3 times daily', 25.00, 50, '2026-07-31', 'Various', '4800009012352', 1),

-- Antihistamines
('Cetirizine 10mg', 'Cetirizine HCl', 'Generic', 5, 'Non-drowsy allergy relief', '1 tablet daily', 12.00, 140, '2026-09-30', 'Various', '4800009012353', 0),

-- Additional Products
('Multivitamin Daily', 'Multivitamin Complex', 'Generic', 3, 'Complete daily vitamin supplement', '1 tablet daily', 18.99, 200, '2027-01-31', 'Various', '4800009012354', 0),
('Antifungal Cream', 'Miconazole', 'Generic', 7, 'Antifungal skin treatment', 'Apply topically 2-3 times daily', 14.50, 60, '2026-05-31', 'Various', '4800009012355', 0),
('Vitamin D3 1000IU', 'Cholecalciferol', 'Generic', 3, 'Bone and immune health', '1 tablet daily', 16.99, 120, '2027-03-31', 'Various', '4800009012356', 0);

-- Insert Sample Admin User (password: Admin123456)
INSERT INTO users (name, email, password, role, contact_number, address, status) VALUES
('System Administrator', 'admin@lavenderpharmacy.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/LaS', 'admin', '09188887673', 'Lavender Pharmacy, Manila', 'active');

-- Insert Sample Editor User (password: Editor123456)
INSERT INTO users (name, email, password, role, contact_number, address, status) VALUES
('Product Editor', 'editor@lavenderpharmacy.com', '$2y$10$QyX.F6FT8/LewKMQvjVh..9yyqtJZkHjEhYnRDGODPu8nLPvZVJwm', 'editor', '09188887674', 'Lavender Pharmacy, Manila', 'active');

-- Insert Sample Customer User (password: Customer123456)
INSERT INTO users (name, email, password, role, contact_number, address, status) VALUES
('John Doe', 'customer@lavenderpharmacy.com', '$2y$10$2ixTYG63GJRhX3TYfQRQwuoJZnFI2Zo8MjvDU8gEqKb3WUEMyVmk6', 'customer', '09123456789', 'Sample Address, Manila', 'active');
