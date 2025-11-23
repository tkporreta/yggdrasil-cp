-- =================================================================
-- Ragnarok Database Setup for Multi-Account System
-- =================================================================
-- This file contains necessary modifications to the Ragnarok
-- database to support the multi-account/master-account system.
--
-- Run this AFTER your standard Ragnarok database installation.
-- =================================================================

USE ragnarok;

-- Remove UNIQUE constraint from web_auth_token
-- This allows multiple game accounts to be linked to one web user
ALTER TABLE login DROP INDEX IF EXISTS web_auth_token_key;

-- Create regular index for query performance
-- This optimizes lookups when finding all accounts for a user
CREATE INDEX IF NOT EXISTS idx_web_auth_token ON login (web_auth_token);

-- Verify the changes
SHOW INDEX FROM login WHERE Key_name = 'idx_web_auth_token';

-- =================================================================
-- EXPLANATION:
-- 
-- The web_auth_token field links game accounts (ragnarok.login)
-- to web users (mysql.users). In a multi-account system:
--
-- - One web user (ID: 2) can have multiple game accounts
-- - Account 1: userid='nana12', web_auth_token='2'
-- - Account 2: userid='zoas13', web_auth_token='2'
-- - Account 3: userid='warrior01', web_auth_token='2'
--
-- The UNIQUE constraint prevented this, so we removed it.
-- The regular index maintains query performance.
-- =================================================================
