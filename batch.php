<?php
date_default_timezone_set('Asia/Tokyo');

class AppleRankingXmlDownloader
{
    const SRC_DIR = "./src";
    const OUTPUT_DIR = "./data";

    private $countries = [
        'jp',
        'us',
        'cn',
        'kr',
    ];

    private $srcPrefix = [
        'topfree',
        'toppaid',
        'topgrossing',
    ];

// データ格納用ディレクトリが存在しなければ作る
    public function makeOutputDir()
    {
        if (!is_dir(self::OUTPUT_DIR)) {
            mkdir(self::OUTPUT_DIR, 0777);
        }

        foreach ($this->countries as $country) {
            $chkDir = self::OUTPUT_DIR . '/' . $country;
            if (!is_dir($chkDir)) {
                mkdir($chkDir, 0777);
            }
        }
    }

    private function getInputFilename($country, $srcPrefix)
    {
        return sprintf("%s/%s_%s.list", self::SRC_DIR, $country, $srcPrefix);
    }

    private function getWgetCommand($xmlUrl, $outputFilename)
    {
        return sprintf("wget %s -O %s", $xmlUrl, $outputFilename);
    }

    private function getOutputFilename($country, $srcPrefix, $category)
    {
        return sprintf("%s/%s/%s_%s_%s.xml", self::OUTPUT_DIR, $country, $srcPrefix, $category, date('Ymd'));
    }

    public function downloadXml()
    {
        foreach ($this->countries as $country) {
            foreach ($this->srcPrefix as $srcPrefix) {
                $contents = @file($this->getInputFilename($country, $srcPrefix));
                foreach ($contents as $line) {
                    list($category, $xmlUrl) = explode("," ,$line);
                    $category = trim($category);
                    $xmlUrl = trim($xmlUrl);
                    $outputFilename = $this->getOutputFilename($country, $srcPrefix, $category);
                    system($this->getWgetCommand($xmlUrl, $outputFilename));
                }
            }
        }
    }
}

$downloader = new AppleRankingXmlDownloader();
$downloader->makeOutputDir();
$downloader->downloadXml();
