<?php

declare(strict_types=1);

namespace Ndarproj\AxieGeneParser;

require_once __DIR__ . '/../vendor/autoload.php';

use Exception;
use Ndarproj\AxieGeneParser\Models\BinBodySkin;
use Ndarproj\AxieGeneParser\Models\BinClass;
use Ndarproj\AxieGeneParser\Models\BinPartSkin;
use Ndarproj\AxieGeneParser\Models\BinRegion;
use Ndarproj\AxieGeneParser\Models\BinTag;
use Ndarproj\AxieGeneParser\Models\BodySkin;
use Ndarproj\AxieGeneParser\Models\ClassColor;
use Ndarproj\AxieGeneParser\Models\Cls;
use Ndarproj\AxieGeneParser\Models\PartSkin;
use Ndarproj\AxieGeneParser\Models\PartType;
use Ndarproj\AxieGeneParser\Models\Region;
use Ndarproj\AxieGeneParser\Models\Tag;
use stdClass;


enum HexType: int
{
    case Bit256 = 256;
    case Bit512 = 512;
}

/**
 * Stores the gene information of an Axie. These informations are parsed from the provided hex representation of
 * the Axie's gene on its constructor call. Supports both 256 and 512 bit hex genes.
 *
 */
class AxieGene
{
    /** Stores the grouped binary values from the hex value. */
    private $geneBinGroup;
    /** Stores the gene details from the parsed binary values. */
    private $_genes;
    /** Stores the gene hex type wether its in 256 or 512 bit. */
    private $_hexType;

    /**
     * Used to initialize an AxieGene object from a hex representation of the Axie's gene.
     * @param hex hex representation of the Axie's gene.
     * @param hexType represents if the provided hex gene is in 256 or 512 bit.
     */
    public function __construct(string $hex, HexType $hexType = HexType::Bit256)
    {
        $this->_hexType = $hexType->value;
        // Convert the hex string into binary and divided them to their respective groups.
        $this->geneBinGroup = $this->parseHex($hex);
        // Parse the binary values into their gene details.
        $this->_genes = $this->parseGenes();
    }

    /**
     * Getter for all of the details of the Axie's gene.
     * @returns Objects that contains all of the details about of the Axie's gene.
     */
    public function getGenes()
    {
        return $this->_genes;
    }

    /**
     * Getter for the class of the Axie.
     * @returns Class of the Axie.
     */
    public function getCls(): Cls
    {
        return $this->_genes->cls;
    }

    /**
     * Getter for the region of the Axie.
     * @returns Region of the Axie.
     */
    public function getRegion(): Region
    {
        return $this->_genes->region;
    }

    /**
     * Getter for the tag associated with the Axie.
     * @returns Tag associated with the Axie.
     */
    public function getTag(): Tag
    {
        return $this->_genes->tag;
    }

    /**
     * Getter for the body skin of the Axie.
     * @returns Skin of the Axie's body.
     */
    public function getBodySkin(): BodySkin
    {
        return $this->_genes->bodySkin;
    }

    /**
     * Getter for the pattern genes of the Axie.
     * @returns Genes for the Axie's pattern.
     */
    public function getPattern()
    {
        return $this->_genes->pattern;
    }

    /**
     * Getter for the color genes of the Axie.
     * @returns Genes for the Axie's color.
     */
    public function getColor()
    {
        return $this->_genes->color;
    }

    /**
     * Getter for the eye genes of the Axie.
     * @returns Genes for the Axie's eye.
     */
    public function getEyes()
    {
        return $this->_genes->eyes;
    }

    /**
     * Getter for the ears genes of the Axie.
     * @returns Genes for the Axie's ears.
     */
    public function getEars()
    {
        return $this->_genes->ears;
    }

    /**
     * Getter for the horn genes of the Axie.
     * @returns Genes for the Axie's horns.
     */
    public function getHorn()
    {
        return $this->_genes->horn;
    }

    /**
     * Getter for the mouth genes of the Axie.
     * @returns Genes for the Axie's mouth.
     */
    public function getMouth()
    {
        return $this->_genes->mouth;
    }

    /**
     * Getter for the back genes of the Axie.
     * @returns Genes for the Axie's back.
     */
    public function getBack()
    {
        return $this->_genes->back;
    }

    /**
     * Getter for the tail genes of the Axie.
     * @returns Genes for the Axie's tail.
     */
    public function getTail()
    {
        return $this->_genes->tail;
    }

    /**
     * Converts the hex into its binary representation and divides them based on their respective respective groups.
     * Each group represents a part of an Axie.
     * @private
     * @param hex hex representation of an Axie's gene.
     * @returns An object that contains the binary value from the hex. The binary values are divided into their respective
     * group based on the gene detail that they represent.
     */
    private function parseHex(string $hex)
    {
        $hexBin = '';
        // Remove the hex prefix.
        $hex = str_replace('0x', '', $hex);

        $splitHex = str_split($hex);

        // Convert each hex character to its binary equivalent.
        foreach ($splitHex as $h) {
            $hexBin .= str_pad(base_convert($h, 16, 2), 4, "0", STR_PAD_LEFT);
        }

        $hexBin = str_pad($hexBin, $this->_hexType, "0", STR_PAD_LEFT);

        // Divide the binary values into their respective groups.
        $groups = new stdClass();
        $groups->cls = $this->_hexType === HexType::Bit256->value ? substr($hexBin, 0, 4) : substr($hexBin, 0, 5);
        $groups->region = $this->_hexType === HexType::Bit256->value ? substr($hexBin, 8, 5) : substr($hexBin, 22, 18);
        $groups->tag = $this->_hexType === HexType::Bit256->value ? substr($hexBin, 13, 5) : substr($hexBin, 40, 15);
        $groups->bodySkin = $this->_hexType === HexType::Bit256->value ? substr($hexBin, 18, 4) : substr($hexBin, 61, 4);
        $groups->xMas = $this->_hexType === HexType::Bit256->value ? substr($hexBin, 22, 12) : "";
        $groups->pattern = $this->_hexType === HexType::Bit256->value ? substr($hexBin, 34, 18) : substr($hexBin, 65, 27);
        $groups->color = $this->_hexType === HexType::Bit256->value ? substr($hexBin, 52, 12) : substr($hexBin, 92, 18);
        $groups->eyes = $this->_hexType === HexType::Bit256->value ? substr($hexBin, 64, 32) : substr($hexBin, 149, 43);
        $groups->mouth = $this->_hexType === HexType::Bit256->value ? substr($hexBin, 96, 32) : substr($hexBin, 213, 43);
        $groups->ears = $this->_hexType === HexType::Bit256->value ? substr($hexBin, 128, 32) : substr($hexBin, 277, 43);
        $groups->horn = $this->_hexType === HexType::Bit256->value ? substr($hexBin, 160, 32) : substr($hexBin, 341, 43);
        $groups->back = $this->_hexType === HexType::Bit256->value ? substr($hexBin, 192, 32) : substr($hexBin, 405, 43);
        $groups->tail = $this->_hexType === HexType::Bit256->value ? substr($hexBin, 224, 32) : substr($hexBin, 469, 43);

        return $groups;
    }

    /**
     * Converts the binary values into a human-readable format in the form of a Gene object.
     * @private
     * @returns Gene Gene object that contains the set of gene information.
     */
    private function parseGenes()
    {
        $obj = new stdClass();
        $obj->cls = $this->parseClass()->value;
        $obj->region = $this->parseRegion()->value;
        $obj->tag = $this->parseTag()->value;
        $obj->bodySkin = $this->parseBodySkin()->value;
        $obj->parsePatternGenes = $this->parsePatternGenes();
        $obj->color = $this->parseColorGenes();
        $obj->eyes = $this->parsePart($this->geneBinGroup->eyes, PartType::Eyes);
        $obj->ears = $this->parsePart($this->geneBinGroup->ears, PartType::Ears);
        $obj->horn = $this->parsePart($this->geneBinGroup->horn, PartType::Horn);
        $obj->mouth = $this->parsePart($this->geneBinGroup->mouth, PartType::Mouth);
        $obj->back = $this->parsePart($this->geneBinGroup->back, PartType::Back);
        $obj->tail = $this->parsePart($this->geneBinGroup->tail, PartType::Tail);

        return $obj;
    }

    /**
     * Parse the class binary values from the GeneBinGroup into a Cls object.
     * @private
     * @returns Cls class of the Axie.
     */
    private function parseClass(): Cls
    {
        $ret = BinClass::get[(string)$this->geneBinGroup->cls];
        if (!$ret) {
            throw new Exception("cannot recognize class");
        }
        return $ret;
    }

    /**
     * Parse the region binary values from the GeneBinGroup into a Region object.
     * @private
     * @returns Region region of the Axie.
     */
    private function parseRegion(): Region
    {
        $ret = BinRegion::get[(string)$this->geneBinGroup->region];

        if (!$ret) {
            // Check if the axie has any japanese parts for 512 bit genes.
            if ($this->_hexType === HexType::Bit512->value) {
                if (substr($this->geneBinGroup->eyes, 0, 4) === "0011") return Region::Japan;
                if (substr($this->geneBinGroup->mouth, 0, 4) === "0011") return Region::Japan;
                if (substr($this->geneBinGroup->ears, 0, 4) === "0011") return Region::Japan;
                if (substr($this->geneBinGroup->horn, 0, 4) === "0011") return Region::Japan;
                if (substr($this->geneBinGroup->back, 0, 4) === "0011") return Region::Japan;
                if (substr($this->geneBinGroup->tail, 0, 4) === "0011") return Region::Japan;
                if ($this->geneBinGroup->region === "000000000000000000");
            }
            throw new Exception("cannot recognize region");
        }
        return $ret;
    }

    /**
     * Parse the tag binary values from the GeneBinGroup into a Tag object.
     * @private
     * @returns Tag tag of the Axie.
     */
    private function parseTag(): Tag
    {
        if ($this->geneBinGroup->tag === "000000000000000") {
            $bionicParts = [
                $this->parsePartSkin(
                    $this->geneBinGroup->region,
                    substr($this->geneBinGroup->eyes, 0, 4)
                )->value,
                $this->parsePartSkin(
                    $this->geneBinGroup->region,
                    substr($this->geneBinGroup->ears, 0, 4)
                )->value,
                $this->parsePartSkin(
                    $this->geneBinGroup->region,
                    substr($this->geneBinGroup->horn, 0, 4)
                )->value,
                $this->parsePartSkin(
                    $this->geneBinGroup->region,
                    substr($this->geneBinGroup->mouth, 0, 4)
                )->value,
                $this->parsePartSkin(
                    $this->geneBinGroup->region,
                    substr($this->geneBinGroup->back, 0, 4)
                )->value,
                $this->parsePartSkin(
                    $this->geneBinGroup->region,
                    substr($this->geneBinGroup->tail, 0, 4)
                )->value,
            ];
            return in_array(PartSkin::Bionic->value, $bionicParts)
                ? Tag::Agamogenesis
                : Tag::Default;
        }
        $ret = BinTag::get[$this->geneBinGroup->tag];
        if (!$ret) {
            throw new Exception("cannot recognize tag");
        }
        return $ret;
    }

    /**
     * Parse the body skin binary values from the GeneBinGroup into a BodySkin object.
     * @private
     * @returns BodySkin body skin of the Axie.
     */
    private function parseBodySkin(): BodySkin
    {
        $ret = BinBodySkin::get[(string)$this->geneBinGroup->bodySkin];
        if (!$ret) {
            throw new Exception("cannot recognize body skin");
        }
        return $ret;
    }

    /**
     * Parse the pattern gene binary values from the GeneBinGroup into a PatternGene object.
     * @private
     * @returns PatternGene pattern gene of the Axie.
     */
    private function parsePatternGenes()
    {
        $bSize = strlen($this->geneBinGroup->pattern) / 3;

        $obj = new stdClass();
        $obj->d = substr($this->geneBinGroup->pattern, 0, $bSize);
        $obj->r1 = substr($this->geneBinGroup->pattern, $bSize, $bSize);
        $obj->r1 = substr($this->geneBinGroup->pattern, $bSize, $bSize);
        $obj->r2 = substr($this->geneBinGroup->pattern, $bSize * 2, $bSize);

        return $obj;
    }

    /**
     * Parse the color gene binary values from the GeneBinGroup into a ColorGene object.
     * @private
     * @returns ColorGene color gene of the Axie.
     */
    private function parseColorGenes()
    {
        $bSize = strlen($this->geneBinGroup->color) / 3;
        $cls = $this->parseClass();
        $clSKey = array_search($cls, array_column(ClassColor::get, 'class'));
        $clsColor = ClassColor::get[$clSKey][0];

        $dVal = substr(substr($this->geneBinGroup->color, 0, $bSize), -4) ?? substr($this->geneBinGroup->color, 0, $bSize);
        $r1Val = substr(substr($this->geneBinGroup->color, $bSize, $bSize), -4) ?? substr($this->geneBinGroup->color, $bSize, $bSize);
        $r2Val = substr(substr($this->geneBinGroup->color, $bSize * 2, $bSize * 2), -4) ?? substr($this->geneBinGroup->color, $bSize, $bSize * 2);

        $obj = new stdClass();
        $obj->d = $clsColor[$dVal];
        $obj->r1 = $clsColor[$r1Val];
        $obj->r2 = $clsColor[$r2Val];

        return $obj;
    }

    /**
     * Parse the part gene binary values from the GeneBinGroup into a Part object.
     * @private
     * @param partBin binary of the part that will be parsed.
     * @param partType part type that will be parsed. A part type refers to an Axie's body part including: Eyes, Ears, Mouth, Back, Horn, Tail
     * @returns Part part gene of the Axie.
     */
    private function parsePart(string $partBin, PartType $partType)
    {
        // Get the region and skin values needed to parse the correct part gene
        $regionBin = $this->geneBinGroup->region;

        $dSkinBin =
            $this->_hexType === HexType::Bit256->value
            ? substr($partBin, 0, 2)
            : substr($partBin, 0, 4);

        $rSkinBin = $this->_hexType === HexType::Bit256->value ? "00" : $dSkinBin;

        $dSkin = $this->parsePartSkin($regionBin, $dSkinBin);
        $rSkin = $this->parsePartSkin($regionBin, $rSkinBin);


        // Get the dominant gene
        $dClass = $this->parsePartClass(
            $this->_hexType === HexType::Bit256->value
                ? substr($partBin, 2, 4)
                : substr($partBin, 4, 5)
        );
        $dBin =
            $this->_hexType === HexType::Bit256->value
            ? substr($partBin, 6, 6)
            : substr($partBin, 11, 6);

        $dName = $this->parsePartName($dClass, $partType, $regionBin, $dBin, $dSkin);

        // Get the recessive 1 gene
        $r1Class = $this->parsePartClass(
            $this->_hexType === HexType::Bit256->value
                ? substr($partBin, 12, 4)
                : substr($partBin, 17, 5)
        );
        $r1Bin =
            $this->_hexType === HexType::Bit256->value
            ? substr($partBin, 16, 6)
            : substr($partBin, 24, 6);
        $r1Name = $this->parsePartName(
            $r1Class,
            $partType,
            $regionBin,
            $r1Bin,
            $rSkin
        );

        // Get the recessive 2 gene
        $r2Class = $this->parsePartClass(
            $this->_hexType === HexType::Bit256->value
                ? substr($partBin, 22, 4)
                : substr($partBin, 30, 5)
        );
        $r2Bin =
            $this->_hexType === HexType::Bit256->value
            ? substr($partBin, 26, 6)
            : substr($partBin, 37, 6);
        $r2Name = $this->parsePartName(
            $r2Class,
            $partType,
            $regionBin,
            $r2Bin,
            $rSkin
        );

        $obj = new stdClass();
        $obj->d = $this->parsePartGene($partType, $dName);
        $obj->r1 = $this->parsePartGene($partType, $r1Name);
        $obj->r2 =  $this->parsePartGene($partType, $r2Name);
        $obj->mystic = $dSkin === PartSkin::Mystic || $dSkinBin === "0001" ? 'true' : 'false';

        return $obj;
    }

    /**
     * Parse the class of the given part into a Cls object.
     * @private
     * @param bin binary representation of an Axie's body part.
     * @returns Cls class of the Axie's body part.
     */
    private function parsePartClass(string $bin): Cls
    {
        $ret = Binclass::get[$bin];
        if (!$ret) {
            throw new Exception("cannot recognize part class");
        }
        return $ret;
    }

    /**
     * Parse the name of an Axie's body part based on its class, part type, region, part binary, and skin binary.
     * @private
     * @param cls class of the Axie's body part.
     * @param partType part type that will be parsed.
     * @param regionBin region binary of the Axie.
     * @param partBin part binary of the Axie.
     * @param skin skin type of the Axie's part.
     * @returns Cls class of the Axie.
     */
    private function parsePartName(
        Cls $cls,
        PartType $partType,
        string $regionBin,
        string $partBin,
        PartSkin $skin
    ): string {
        $part = json_decode(file_get_contents(__DIR__ . '/Assets/traits.json'), true)[$cls->value][$partType->value][$partBin];

        if (!$part) throw new Exception("cannot recognize part binary");
        $ret = $part[$skin->value];
        if (!$ret) {
            $fallBack = $part[PartSkin::Global->value];
            if (!$fallBack) throw new Exception("cannot recognize part skin");
            $ret = $fallBack;
        }

        return $ret;
    }


    /**
     * Converts the part type and name into a format used as the partId. A lookup is then performed from the contents
     * of the parts.json file to match the partId with the part gene presets.
     * @private
     * @param partType body part that will be parsed.
     * @param partName name of the specific body part.
     * @returns PartGene an objects that contains the part class, id, name, type, and if it is a special gene.
     */
    private function parsePartGene(PartType $partType, string $partName)
    {
        $partId =  implode("-", explode(" ",  $partType->value . '-' . strtolower($partName)));
        $partId = str_replace("'", "", $partId);
        $partId = str_replace(".", "", $partId);

        $partJson = json_decode(file_get_contents(__DIR__ . '/Assets/parts.json'), true)[$partId];
        if (!$partJson) {
            throw new Exception("cannot recognize part gene");
        } else {
            $obj = new stdClass();
            $obj->cls = $partJson['class'];
            $obj->name = $partJson['name'];
            $obj->partId = $partId;
            $obj->specialGenes = $partJson['specialGenes'];
            $obj->type = $partJson['type'];

            return $obj;
        }
    }

    /**
     * Parses the skin of the part based on its region and skin binary value.
     * @private
     * @param regionBin region binary of the Axie.
     * @param skinBin skin binary of the Axie.
     * @returns PartSkin skin of the Axie's body part.
     */
    private function parsePartSkin(string $regionBin, string $skinBin): PartSkin
    {
        $ret = BinPartSkin::get[$skinBin] ?? null;
        if ($skinBin === "00") {
            if ($this->geneBinGroup->xMas === "010101010101") $ret = PartSkin::Xmas1;
            else $ret = BinPartSkin::get[$regionBin];
        }
        if (!$ret) {
            throw new Exception("cannot recognize part skin");
        }
        return $ret;
    }
    /**
     * Calculates the purity or gene quality of the Axie's gene.
     * @returns a number that represents the quality of the gene in percentage.
     */
    public function getGeneQuality(): float
    {
        $geneQuality = 0;
        $geneQuality += $this->getPartQuality($this->_genes->eyes);
        $geneQuality += $this->getPartQuality($this->_genes->ears);
        $geneQuality += $this->getPartQuality($this->_genes->mouth);
        $geneQuality += $this->getPartQuality($this->_genes->horn);
        $geneQuality += $this->getPartQuality($this->_genes->back);
        $geneQuality += $this->getPartQuality($this->_genes->tail);
        return floatval(number_format($geneQuality, 2));
    }


    /**
     * Calculate the purity or gene quality of the Axie's individual parts.
     * @param part part genes the will be used for the calculation.
     * @private
     * @returns an integer that represents the quality of the individual part in percentage.
     */
    private function getPartQuality($part): float
    {
        $cls = $this->_genes->cls;
        $partQuality = 0;
        $partQuality += $part->d->cls === $cls ? 76 / 6 : 0;
        $partQuality += $part->r1->cls === $cls ? 3 : 0;
        $partQuality += $part->r2->cls === $cls ? 1 : 0;
        return $partQuality;
    }
}


$test = new AxieGene("0x11c642400a028ca14a428c20cc011080c61180a0820180604233082");
$test->getGeneQuality();
