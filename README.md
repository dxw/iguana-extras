# iguana-extras

Helpful gubbins for [iguana](https://github.com/dxw/iguana)-based themes.

## `\Dxw\Iguana\Extras\UseAtom`

Set the default feed to Atom, remove the ability to view non-Atom feeds, add `link[rel="alternate"]` to `head` for the feed.

### Installation

Add the following to `app/di.php`:

```
$registrar->addInstance(\Dxw\Iguana\Extras\UseAtom::class, new \Dxw\Iguana\Extras\UseAtom());
```

## Licence

[MIT](COPYING.md)
