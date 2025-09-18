-- Add profile_image column to user table
ALTER TABLE `user` ADD COLUMN `profile_image` VARCHAR(255) NULL AFTER `postal_code`;

-- Update existing users to have default profile image
UPDATE `user` SET `profile_image` = 'assets/img/default-avatar.png' WHERE `profile_image` IS NULL;

