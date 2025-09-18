-- Tambah kolom stok pada tabel menus jika belum ada
ALTER TABLE `menus`
  ADD COLUMN `stock` INT NOT NULL DEFAULT 0 AFTER `price`;

-- Opsional: set semua menu tersedia jika stock > 0
-- UPDATE `menus` SET `is_available` = CASE WHEN `stock` > 0 THEN 1 ELSE `is_available` END;



