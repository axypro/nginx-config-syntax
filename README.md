# axy\nginx\config\syntax

[![Latest Stable Version](https://img.shields.io/packagist/v/axy/nginx-config-syntax.svg?style=flat-square)](https://packagist.org/packages/axy/nginx-config-syntax)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.0-8892BF.svg?style=flat-square)](https://php.net/)
[![License](https://poser.pugx.org/axy/nginx-config-syntax/license)](LICENSE)

Builds a file with syntax similar to nginx config.
Nginx-specific directives are implemented in a separate package.

## Structure

* There is a "context" on the top level
* Context contains list of items
* An item can be "directive" or "comment"
* There are two type of directives: single and block
* A directive of any type has "name" and list of parameters (can be empty, a parameter is a string)
* A block directive has nested context
* Nested context contains list of items, etc. The number of levels is not limited

## Syntax

```
# The main context
# Comment line starts with "#"
# Indents doesn't matter
# Empty strings doesn't matter

single_directive;
single_directive_with_parameters one two three;

block_directive param1 param2 {
    # Nested context
    nested_single_directive;
    nested_block_directive {
        nested_nested_single_directive param;
    }
}
```

## Example

```php
use axy\nginx\config\syntax\Context;

$main = new Context();
$main->comment->set([
    'The main context',
    'Comment line starts with "#"', 'Indents doesn\'t matter',
    'Empty strings doesn\'t matter',
]);

$main->append('');
$main->single('single_directive');
$directive = $main->single('single_directive_with_parameters', ['one', 'two']);
$directive->params[] = 'three';
$main->append('');

$block = $main->block('block_directive', ['param1', 'param2']);
$block->context->single('nested_single_directive');
$nested = $block->context->block('nested_block_directive');
$nested->context->single('nested_nested_single_directive', 'param');
$block->context->comment->set('Nested context');

$expected = rtrim(file_get_contents(__DIR__ . '/example.txt')) . "\n";
$this->assertSame($expected, $main->render());
```

Result is the text from "syntax" section.

## Class hierarchy

* `BaseItem`
    * `BaseContext`
        * `Context`
            * `DirectiveContext`
    * `BaseDirective`
        * `SingleDirective`
            * `CustomSingleDirective`
        * `BlockDirective`
            * `CustomBlockDirective`
* `Comment`

### Context

A `context` has the public array `$items`.
When a context is rendering it renders all items in order.

An item can be any value (object or scalar) that can be cast to a string.

```php
$context->append(new CustomeSingleDirective('name')); // append BaseItem
$context->append('other_directive;'); // or just a string
```

An item is rendered on a separate line (or several lines) with indentation of the current context.
If a scalar item converts to empty line it will take one empty line in the output.
If an object item converts to empty line it will take no lines.

Methods and properties:

* Can work with the `$items` array directly
* `append($item): void` - appends an item to the array
* `single($name [, $params]): CustomSingleDirective` - helper for easy creation of a single directive (see below). Creates, appends and returns.
* `block($name [, $params]): CustomBlockDirective` - helper for block directive creation

### Directives

`CustomSingleDirective` and `CustomBlockDirective` used for easy creation directives.
They take as arguments in the constructor:

* `$name` (string) - the directive name
* `$params` - list of parameters
    * available as public property and can be changed afterwards
    * NULL - no params
    * string - displayed as is (without escaping)
    * string[] - list of parameters, escaped and imploded
        * escaped spaces and quoted
        * _not sure if this is correct_

```
$directive = new CustomSingleDirective('my_directive', 'param');
echo $directive; // my_directive param;
```

Base classes `SingleDirective` and `BlockDirective` are used as parent for specific directive classes.

### Block directive context

`BlockDirective` has the public property `$context`.

```
$block = new CustomBlockDirective('block');
$block->context->append('one');
$block->append('two'); // alias for $block->context->append()
```

Result:

```
block {
    one
    two
}
```

There are `$topContext` and `$mainContext` (protected) also.
They are appended to `$context` automatically.
Usually it is enough to use `$context` only.

But a specific directive class should write its content to the `$mainContext`.
If the user want to add custom directives they can use `$context->appned()` (append to the bottom) or `$topContext->append()`.

### Disable directive

All directive objects is enabled by default.
But can be disabled and will not be displayed.

* `isEnabled(): bool`
* `enable(): void`
* `disable(): void`

### Comment

All directive and context objects have the public property `comment`.

```php
$directive = new CustomSingleDirective('name');
$directive->comment->set('It is directive');
```

Result:

```
# It is directive
name;
```

`set()` can take:

* string - the comment content, can be multiline
* string[] - will be imploded
* NULL - no comment (by default)
* `delete()` is alias for `set(null)`

Can set comment for a block directive and for its context:

```php
$block = new CustomBlockDirective('block');
$block->context->single('single');
$block->comment->set('It is directive');
$block->context->comment->set('It is context');
```

Result:

```
# It is directive
block {
    # It is context
    single;
}
```

## Render

All `BaseItem` implement `__toString()`, but there are nuances:

* There may be trailing spaces
* Tabs are used for indentation (one tab per nested level)
* "\n" for line breaks

For formatting on the top level can be used `render()` method.
Arguments:

* `$indent` (string, 4 spaces by default) - replaces tabs
* `$clear` (bool, FALSE by default) - deletes comment lines and empty lines
* `$rtrim` (bool, TRUE by default) - deletes tailing spaces, empty lines at the end and ends the file by one blank line
* `$nl` (string, "\n" by default) - line break symbol
