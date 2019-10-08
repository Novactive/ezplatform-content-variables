# eZ Platform Content Variables

This bundle provides a way to manage content variables. Basically, those are placeholders you can use anywhere in your content (in any field types). And they will be replaced with actual values during the page rendering.

## Installation

1. Require `contextualcode/ezplatform-content-variables` via `composer`:
    ```bash
   composer require contextualcode/ezplatform-content-variables
    ```
   
2. Activate the bundle in `app/AppKernel.php`:
    ```php
    $bundles = [
       ...
       new ContextualCode\EzPlatformContentVariablesBundle\EzPlatformContentVariablesBundle(),
    ];
    ```

3. Add bundle routes in `app/config/routing.yml`:
    ```yaml
    content_variables:
        resource: "@EzPlatformContentVariablesBundle/Resources/config/routing.yml"
    ```

4. Please make sure you have enabled [DoctrineMigrationsBundle](https://github.com/doctrine/DoctrineMigrationsBundle). Otherwise, it needs to be added to your project. Please follow [the installation instructions](https://symfony.com/doc/master/bundles/DoctrineMigrationsBundle/index.html#installation).

5. Run the mirations:
    ```bash
   php bin/console doctrine:migrations:migrate --configuration=vendor/contextualcode/ezplatform-content-variables/src/bundle/Resources/config/doctrine_migrations.yaml
    ```

6. Clear the caches:
    ```bash
    php bin/console cache:clear
    ```

7. Complie the assets:
    ```bash
    yarn encore dev
    ```

## Usage

All the content variables are grouped in the collections. So first you would need to define those collections. To do so, just open an eZ Platfrom admin interface and go to "Content > Variables". And create a first content variables collection.

After the collection is created, you would need to add some variables. Just click on the collection name and add a few content variables. You would need to specify the following parameters for each variable:
- Name
- Identifier
- Value

There is two types of content variables: static and callback. No default callbacks are provided out of the box, but it is very easy to create a new one:

1. Create a new `AppBundle\ContentVariables\Random` service (`src/AppBundle/ContentVariables/Random.php`), which extends `ContextualCode\EzPlatformContentVariables\Variable\Value\Callback`.
    ```php
    <?php
    
    namespace AppBundle\ContentVariables;
    
    use ContextualCode\EzPlatformContentVariables\Variable\Value\Callback;
    
    class Random extends Callback
    {
        protected $identifier = 'random';
    
        public function getValue(): string
        {
            return rand(0, 100);
        }
    }
    ```

2. In the `AppBundle\ContentVariables\Random` service you need to:
    - Define `$identifier` property, it need to be unique in the scope of your project
    - Implement `getValue` function, it does not take any arguments and should return a string value. You can use any injected services in this function.
    
3. Tag `AppBundle\ContentVariables\Random` with `content_variables.value.callback`:
    ```yaml
    AppBundle\ContentVariables\Random:
        tags: [content_variables.value.callback]
    ```

Thats all, now when you add/edit any contnet variable you would be able to chose `random` callback for it.

After some content variables are created, you can use them in any content fields. To do so, please use a variable identifier wrapped with `#` sign. For example, if you have a variable with `random_var` identifier, try to add `#random_var#` to some pages content. And check edited content on the front-end siteaccess. An actual random number should be be shown instead of `#random_var`.
