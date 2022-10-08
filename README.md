# Axie gene parser for PHP

This is a port of the Javascript version of a plugin, you can find it here: [agp-npm](https://github.com/ShaneMaglangit/agp-npm)

Package `agp-php` is a gene parsing package for Axie Infinity.

The name agp stands for "Axie Gene Parser" which decodes the hex representation of an Axie's gene into a human readable
format.

## Requirements

Composer, PHP 8.0 or later.

## Installation

Install using Composer:

```
composer require ndarproj/agp-php
```

## Usage

To get started, you'll first need to get the gene of an Axie in hex. You may use
the [Axie Infinity GraphQL endpoint](https://axie-graphql.web.app/) to get this detail. For this example, let's use the
hex `0x11c642400a028ca14a428c20cc011080c61180a0820180604233082`

Let us create an AxieGene object from the hex string that we have.

256 Bit Genes

```php
use Ndarproj\AxieGeneParser\AxieGene;

$axieGene = new AxieGene(
    "0x11c642400a028ca14a428c20cc011080c61180a0820180604233082"
);
```

512 Bit Genes

```php
use Ndarproj\AxieGeneParser\AxieGene;
use Ndarproj\AxieGeneParser\HexType;

$axieGene = new AxieGene(
    "0x280000000000010040412090830C0000000101942040440A00010190284082040001018C2061000A000101801021400400010180204080060001018418404008",
    HexType::Bit512
);
```

## Gene Quality

You may also get the quality of the genes directly through the AxieGene object.

```php
$axieGene->getGeneQuality();
```

This object automatically handles the parsing of the hex value for you. You may simply use the accessors of the class to
get the gene information that you want.

Here are the properties that you can get from the AxieGene object.

- getGenes()
- getCls()
- getRegion()
- getTag()
- getBodySkin()
- getPattern()
- getColor()
- getEyes()
- getMouth()
- getEars()
- getHorn()
- getBack()
- getTail()
