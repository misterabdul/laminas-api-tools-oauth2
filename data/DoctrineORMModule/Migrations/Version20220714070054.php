<?php

declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714070054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create all oauth-related tables.';
    }

    public function up(Schema $schema): void
    {
        $this->createOauthClientsTable($schema);
        $this->createOauthJwtTable($schema);
        $this->createOauthScopesTable($schema);

        $this->createOauthUsersTable($schema);

        $this->createOauthAccessTokensTable($schema);
        $this->createOauthAuthorizationCodesTable($schema);
        $this->createOauthRefreshTokensTable($schema);
    }

    public function down(Schema $schema): void
    {
        $this->dropOauthRefreshTokensTable($schema);
        $this->dropOauthAuthorizationCodesTable($schema);
        $this->dropOauthAccessTokensTable($schema);

        $this->dropOauthUsersTable($schema);

        $this->dropOauthScopesTable($schema);
        $this->dropOauthJwtTable($schema);
        $this->dropOauthClientsTable($schema);
    }

    protected function createOauthClientsTable(Schema $schema): void
    {
        $table = $schema->createTable('oauth_clients');

        $table->addColumn('client_id', 'string', ['length' => 80]);
        $table->addColumn('client_secret', 'string', ['length' => 80]);
        $table->addColumn('redirect_uri', 'string', ['length' => 2000, 'notnull' => false]);
        $table->addColumn('grant_types', 'string', ['length' => 80]);
        $table->addColumn('scope', 'string', ['length' => 2000, 'notnull' => false]);
        $table->addColumn('user_id', 'string', ['length' => 255, 'notnull' => false]);

        $table->setPrimaryKey(['client_id']);
    }

    protected function dropOauthClientsTable(Schema $schema): void
    {
        $schema->dropTable('oauth_clients');
    }

    protected function createOauthJwtTable(Schema $schema): void
    {
        $table = $schema->createTable('oauth_jwts');

        $table->addColumn('client_id', 'string', ['length' => 80]);
        $table->addColumn('subject', 'string', ['length' => 80, 'notnull' => false]);
        $table->addColumn('public_key', 'string', ['length' => 2000, 'notnull' => false]);

        $table->setPrimaryKey(['client_id']);

        $table->addForeignKeyConstraint(
            'oauth_clients',
            ['client_id'],
            ['client_id'],
            ['onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE'],
            'oauthjwt_client'
        );
    }

    protected function dropOauthJwtTable(Schema $schema): void
    {
        $schema->dropTable('oauth_jwts');
    }

    protected function createOauthScopesTable(Schema $schema): void
    {
        $table = $schema->createTable('oauth_scopes');

        $table->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('type', 'string', ['length' => 255, 'default' => 'supported']);
        $table->addColumn('scope', 'string', ['length' => 2000, 'notnull' => false]);
        $table->addColumn('client_id', 'string', ['length' => 80, 'notnull' => false]);
        $table->addColumn('is_default', 'smallint', ['unsigned' => true, 'notnull' => false]);

        $table->setPrimaryKey(['id']);
        $table->addIndex(['client_id'], 'oauthscope_client_idx');

        $table->addForeignKeyConstraint(
            'oauth_clients',
            ['client_id'],
            ['client_id'],
            ['onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE'],
            'oauthscope_client_fk'
        );
    }

    protected function dropOauthScopesTable(Schema $schema): void
    {
        $schema->dropTable('oauth_scopes');
    }

    protected function createOauthUsersTable(Schema $schema): void
    {
        $table = $schema->createTable('oauth_users');

        $table->addColumn('username', 'string', ['length' => 255]);
        $table->addcolumn('password', 'string', ['length' => 2000, 'notnull' => false]);
        $table->addColumn('first_name', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('last_name', 'string', ['length' => 255, 'notnull' => false]);

        $table->setPrimaryKey(['username']);
    }

    protected function dropOauthUsersTable(Schema $schema): void
    {
        $schema->dropTable('oauth_users');
    }

    protected function createOauthAccessTokensTable(Schema $schema): void
    {
        $table = $schema->createTable('oauth_access_tokens');

        $table->addColumn('access_token', 'string', ['length' => 40]);
        $table->addColumn('client_id', 'string', ['length' => 80]);
        $table->addColumn('user_id', 'string', ['length' => 255]);
        $table->addColumn('expires', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('scope', 'string', ['length' => 2000, 'notnull' => false]);

        $table->setPrimaryKey(['access_token']);
        $table->addIndex(['client_id'], 'oauthacctkn_client_idx');
        $table->addIndex(['user_id'], 'oauthacctkn_user_idx');

        $table->addForeignKeyConstraint(
            'oauth_clients',
            ['client_id'],
            ['client_id'],
            ['onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE'],
            'oauthacctkn_client_fk'
        );
        $table->addForeignKeyConstraint(
            'oauth_users',
            ['user_id'],
            ['username'],
            ['onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE'],
            'oauthacctkn_user_fk',
        );
    }

    protected function dropOauthAccessTokensTable(Schema $schema): void
    {
        $schema->dropTable('oauth_access_tokens');
    }

    protected function createOauthAuthorizationCodesTable(Schema $schema): void
    {
        $table = $schema->createTable('oauth_authorization_codes');

        $table->addColumn('authorization_code', 'string', ['length' => 40]);
        $table->addColumn('client_id', 'string', ['length' => 80]);
        $table->addColumn('user_id', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('redirect_uri', 'string', ['length' => 2000, 'notnull' => false]);
        $table->addColumn('expires', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('scope', 'string', ['length' => 2000, 'notnull' => false]);
        $table->addColumn('id_token', 'string', ['length' => 2000, 'notnull' => false]);

        $table->setPrimaryKey(['authorization_code']);
        $table->addIndex(['client_id'], 'oauthathtkn_client_idx');
        $table->addIndex(['user_id'], 'oauthathtkn_user_idx');

        $table->addForeignKeyConstraint(
            'oauth_clients',
            ['client_id'],
            ['client_id'],
            ['onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE'],
            'oauthathtkn_client_fk'
        );
        $table->addForeignKeyConstraint(
            'oauth_users',
            ['user_id'],
            ['username'],
            ['onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE'],
            'oauthathtkn_user_fk',
        );
    }

    protected function dropOauthAuthorizationCodesTable(Schema $schema): void
    {
        $schema->dropTable('oauth_authorization_codes');
    }

    protected function createOauthRefreshTokensTable(Schema $schema): void
    {
        $table = $schema->createTable('oauth_refresh_tokens');

        $table->addColumn('refresh_token', 'string', ['length' => 40]);
        $table->addColumn('client_id', 'string', ['length' => 80]);
        $table->addColumn('user_id', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('expires', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('scope', 'string', ['length' => 2000, 'notnull' => false]);

        $table->setPrimaryKey(['refresh_token']);
        $table->addIndex(['client_id'], 'oauthrfhtkn_client_idx');
        $table->addIndex(['user_id'], 'oauthrfhtkn_user_idx');

        $table->addForeignKeyConstraint(
            'oauth_clients',
            ['client_id'],
            ['client_id'],
            ['onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE'],
            'oauthrfhtkn_client_fk'
        );
        $table->addForeignKeyConstraint(
            'oauth_users',
            ['user_id'],
            ['username'],
            ['onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE'],
            'oauthrfhtkn_user_fk',
        );
    }

    protected function dropOauthRefreshTokensTable(Schema $schema): void
    {
        $schema->dropTable('oauth_refresh_tokens');
    }
}
