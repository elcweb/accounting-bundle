Getting Started With ElcwebAccountingBundle
===========================================

## Prerequisites

This version of the bundle requires Symfony 2.3+.

## Installation

Installation is a quick process:

1. Download ElcwebAccountingBundle using composer
2. Enable the Bundle
3. Configure the ElcwebAccountingBundle
4. Import ElcwebAccountingBundle routing
5. Update your database schema

### Step 1: Download ElcwebAccountingBundle using composer

Add ElcwebAccountingBundle in your composer.json:

    ```js
    {
        "require": {
            "fpn/doctrine-extensions-taggable"   : "v0.9.0",
            "fpn/tag-bundle"                     : "dev-master",
            "elcweb/tag-bundle"                  : "dev-master",
            "elcweb/accounting-bundle"           : "dev-master",
        }
    }
    ```

Now tell composer to download the bundle by running the command:

    ``` bash
    $ php composer.phar update elcweb/accounting-bundle
    ```

Composer will install the bundle to your project's `vendor/elcweb` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

    ``` php
    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new FPN\TagBundle\FPNTagBundle(),
            new Elcweb\TagBundle\ElcwebTagBundle(),
            new Elcweb\AccountingBundle\ElcwebAccountingBundle(),
        );
    }
    ```

### Step 3: Configure the ElcwebAccountingBundle

Add the following configuration to your `config.yml` file according to which type
of datastore you are using.

    ``` yaml
    # app/config/config.yml
    fpn_tag:
        model:
            tag_class:     Elcweb\TagBundle\Entity\Tag
            tagging_class: Elcweb\TagBundle\Entity\Tagging

    doctrine:
        dbal:
            # Ignore all the views which start with view_
            schema_filter: ~^(?!view_)~

    elcweb_accounting:
    ```

### Step 4: Import ElcwebAccountingBundle routing files

Now that you have activated and configured the bundle, all that is left to do is
import the ElcwebAccountingBundle routing files.

By importing the routing files you will have ready made pages for listing event, etc.

In YAML:

    ``` yaml
    # app/config/routing.yml
    elcweb_accounting:
        resource: "@ElcwebAccountingBundle/Controller/"
        type:     annotation
        prefix:   /
    ```

### Step 5: Update your database schema

For ORM run the following command.

    ``` bash
    $ php app/console doctrine:schema:update
    ```
### Step 6: Create doctrine migration version

    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $sql = "CREATE VIEW view_AccountsDailySummary(id,account_id,day,total) AS
                SELECT CONCAT_WS(  '-', a.id, t.date ) AS new_id, a.id, t.date, SUM( e.amount )
                FROM acc_accounts a
                LEFT JOIN acc_entries e ON e.account_id = a.id
                LEFT JOIN acc_transactions t ON e.transaction_id = t.id
                WHERE t.date IS NOT NULL
                GROUP BY a.id, t.date";

        $this->addSql($sql);
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("DROP VIEW view_AccountsDailySummary");
    }
