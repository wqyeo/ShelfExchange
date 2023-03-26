# Coding Conventions

*Generally, it is best to follow the coding convention based on the current file/directory you are working in.*

## Naming

### File Names

- **Do**  use `camelCase` where possible, for code related files (`js`, `css`, `php`, etc).
- **Prefer** using `Pascal_Snake_Case` for asset files (`png`, `jpg`, etc).

### Directory Names

- **Do** use `camel_snake_case`.

### Code Naming

- **Do** use `ALL_CAP_SNAKE_CASE` for *constants* or global variables.
- **Do** use `camelCase` for other variable names.
- **Do** use `camelCase` for function names.
- **Do** use `PaselCase` for class names.

Names should be clear.
Anyone reading the code should know what the object is for. 

> Avoid generic names such as `data`, `var1`, `tmp`, `flag`, etc.

For clarity as well, avoid abbreviations, single-letter names, and acronyms, in both texts and variables/functions names:
- `pwd` -> `password`
- `site_config` -> `site_configurations`
- `param1` -> `parameter1`
- `dsp` -> `database_server_password`
- `k, v` -> `key, value`
- `data` -> `reviewData`

## Spacing

Generally, if you have a formatter built into your text editor or IDE, you are fine. Try to follow the same spacing as the current/other files you are working with.

## Commenting

All sentence based comments should end with a full stop. If a comment becomes too long, consider multi-line it to a new line instead.

> If a comment manages to reach the right side of your editor, or a scroll to left-right is needed to see the entire comment , that is probably too long.

Generally, **prefer** using `//` for most comments rather than `/* */`.
Though, you can use `/* */` for function identities.

Finally, use `//region` and `//endregion` to 'section' out parts of code if desired.

#### Example
```php
//region Something something code section or region.

/**
* This function does something with that thing.
*
* @param String $thatThing That thing to perform with.
* returns Something related to that thing.
*/
function doSomething(String $thatThing): String {
  // Perform with something.
  return thatThing . " with something";

  // Maybe a three liner comment that can talk about
  // this function. Notice that the full stop is properly
  // used to seperate the two sentences with a multi line comment.
}

//endregion
```
