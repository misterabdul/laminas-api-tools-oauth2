<?php

declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220718154430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create all user-related tables.';
    }

    public function up(Schema $schema): void
    {
        $this->createUserActivationsTable($schema);
        $this->createUserProfilesTable($schema);
        $this->createUserResetPasswordsTable($schema);
    }

    public function down(Schema $schema): void
    {
        $this->dropUserResetPasswordsTable($schema);
        $this->dropUserProfilesTable($schema);
        $this->dropUserActivationsTable($schema);
    }

    protected function createUserActivationsTable(Schema $schema): void
    {
        $table = $schema->createTable('user_activations');

        $table->addColumn('uuid', 'string', ['length' => 36, 'fixed' => true]);
        $table->addColumn('email', 'string', ['length' => 255]);
        $table->addColumn('expiration', 'datetime', []);
        $table->addColumn('activated', 'datetime', ['notnull' => false]);
        $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('deleted_at', 'datetime', ['notnull' => false]);

        $table->setPrimaryKey(['uuid']);
        $table->addIndex(['email'], 'useractv_oauthclient_idx');

        $table->addForeignKeyConstraint(
            'oauth_users',
            ['email'],
            ['username'],
            ['onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE'],
            'useractv_oauthclient_fk'
        );
    }

    protected function dropUserActivationsTable(Schema $schema): void
    {
        $schema->dropTable('user_activations');
    }

    protected function createUserProfilesTable(Schema $schema): void
    {
        $table = $schema->createTable('user_profiles');

        $table->addColumn('uuid', 'string', ['length' => 36, 'fixed' => true]);
        $table->addColumn('user_activation_uuid', 'string', ['length' => 36, 'fixed' => true, 'notnull' => false]);
        $table->addColumn('email', 'string', ['length' => 255]);
        $table->addColumn('first_name', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('last_name', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('dob', 'date', ['notnull' => false]);
        $table->addColumn('address', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('city', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('province', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('postal_code', 'string', ['length' => 5, 'fixed' => true, 'notnull' => false]);
        $table->addColumn('country', 'string', ['length' => 2, 'fixed' => true, 'notnull' => false]);
        $table->addColumn('photo', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('is_active', 'boolean', ['default' => false]);
        $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('deleted_at', 'datetime', ['notnull' => false]);

        $table->setPrimaryKey(['uuid']);
        $table->addIndex(['user_activation_uuid'], 'userprof_useractv_idx');
        $table->addIndex(['email'], 'userprof_oauthclient_idx');
        $table->addUniqueIndex(['email'], 'userprof_email_unq');

        $table->addForeignKeyConstraint(
            'user_activations',
            ['user_activation_uuid'],
            ['uuid'],
            ['onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE'],
            'userprof_useractv_fk'
        );
        $table->addForeignKeyConstraint(
            'oauth_users',
            ['email'],
            ['username'],
            ['onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE'],
            'userprof_oauthclient_fk'
        );
    }

    protected function dropUserProfilesTable(Schema $schema): void
    {
        $schema->dropTable('user_profiles');
    }

    protected function createUserResetPasswordsTable(Schema $schema): void
    {
        $table = $schema->createTable('user_reset_passwords');

        $table->addColumn('uuid', 'string', ['length' => 36, 'fixed' => true]);
        $table->addColumn('email', 'string', ['length' => 255]);
        $table->addColumn('expiration', 'datetime', []);
        $table->addColumn('reseted', 'datetime', ['notnull' => false]);
        $table->addColumn('password', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('deleted_at', 'datetime', ['notnull' => false]);

        $table->setPrimaryKey(['uuid']);
        $table->addIndex(['email'], 'userrstpwd_oauthclient_idx');

        $table->addForeignKeyConstraint(
            'oauth_users',
            ['email'],
            ['username'],
            ['onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE'],
            'userrstpwd_oauthclient_fk'
        );
    }

    protected function dropUserResetPasswordsTable(Schema $schema): void
    {
        $schema->dropTable('user_reset_passwords');
    }
}
