<?php

class ImportEbulletins extends BuildTask {
    protected $title = 'Import eBulletins from www.nedc.com.au';
 
    protected $description = 'A class that extracts and imports eBulletins';
 
    protected $enabled = true;
 
    function run($request) {
        ini_set('memory_limit','2048M');
        ini_set('max_execution_time', 0);    	
        $ebulletinListPageURL = 'http://www.nedc.com.au/e-bulletin';
        $eBulletinListPageContents = $this->file_get_contents_utf8($ebulletinListPageURL);

        $eBulletinURLs = array();
        $importedCount = 0;
        preg_match_all('/\<a href="(http:\/\/(www\.)?nedc\.com\.au\/e-bulletin-number.*?)".*?\<\/a\>( ?\| \<a( target="_blank")? href="(http:\/\/(www\.)?nedc\.com\.au\/files\/[pdfs|enews]+.*?)".*?\<\/a\>)?/si', $eBulletinListPageContents, $eBulletinURLs);

        $assetPath = Director::baseFolder() . '\assets';

        if(count($eBulletinURLs) == 7) {
			// IDX 1 has the links to the online versions of the eBulletins
			// IDX 5 has the links to the PDFs of the eBulletins       	
    		
    		foreach($eBulletinURLs[1] as $i => $url) {
    			$eBulletinPageContents = $this->file_get_contents_utf8($url);

				$eBulletinPageBody = array();
				preg_match('/\<body.*\<\/body\>/si', $eBulletinPageContents, $eBulletinPageBody);

				if(count($eBulletinPageBody)) {
					$eBulletinPageBody = array_shift($eBulletinPageBody);

			 	    $dom = new DOMDocument();
					$dom->preserveWhiteSpace = false;
					$dom->strictErrorChecking = false;
				    @$dom->loadHTML('<?xml encoding="UTF-8">' . $eBulletinPageBody);        
				    $breadCrumb = $dom->getElementById('bread-crumb');
				    $breadCrumb->parentNode->removeChild($breadCrumb);				    

					$xpath = new DOMXPath($dom);
					$centerColumnDiv = $xpath->query('//div[@id="center-column"]')->item(0);					
					
					$images = $centerColumnDiv->getElementsByTagName('img');					
					foreach($images as $img) {						
						$src = $img->getAttribute('src');

						if($src) {
							
							if (DIRECTORY_SEPARATOR == '\\') {
								$fullLocalPathToNewImage = $assetPath . str_replace('/', '\\', $src);
							} else {
								$fullLocalPathToNewImage = $assetPath . $src;
							}

							$src_parts = array_map('rawurldecode', explode('/', $src));
							$src = implode('/', array_map('rawurlencode', $src_parts));
							
							if( !file_exists($fullLocalPathToNewImage) && ($imgFileContents = file_get_contents('http://www.nedc.com.au' . $src)) !== false ) {							
								@mkdir(dirname($fullLocalPathToNewImage), 0777, true);

								$fp = fopen($fullLocalPathToNewImage, 'w');
								fwrite($fp, $imgFileContents);
								fclose($fp);
							}

							$img->setAttribute('src', '/assets' . $src);
						}						
					}

					$links = $centerColumnDiv->getElementsByTagName('a');
					foreach($links as $l) {
						$href = $l->getAttribute('href');

						if($href) {
							// Try and save PDF files
							$hrefSegments = @pathinfo(parse_url($href, PHP_URL_PATH));
							if(isset($hrefSegments['extension']) && $hrefSegments['extension'] == 'pdf') {
								if (DIRECTORY_SEPARATOR == '\\') {
									$fullLocalPathToNewPDF = $assetPath . str_replace('/', '\\', parse_url($href, PHP_URL_PATH));						
								} else {
									$fullLocalPathToNewPDF = $assetPath . parse_url($href, PHP_URL_PATH);
								}

								if( !file_exists($fullLocalPathToNewPDF) && ($pdfFileContents = file_get_contents($href)) !== false ) {							
										@mkdir(dirname($fullLocalPathToNewPDF), 0777, true);

										$fp = fopen($fullLocalPathToNewPDF, 'w');
										fwrite($fp, $pdfFileContents);
										fclose($fp);

										$href = '/assets' . parse_url($href, PHP_URL_PATH);
								}
							} else {
								$hash = parse_url($href, PHP_URL_FRAGMENT);
								$href = ($hash == 'top') ? '#top' : str_replace(array('http://www.nedc.com.au', 'http://nedc.com.au', $url), '', $href);
							}

							$l->setAttribute('href', $href);
						}
					}

					$centerColumnDivChildDivs = $centerColumnDiv->getElementsByTagName('div');
					$social_div = $centerColumnDivChildDivs->item($centerColumnDivChildDivs->length - 1);
					$social_div->parentNode->removeChild($social_div);

					$title_segment = str_replace('http://www.nedc.com.au/e-bulletin-number-', '', $url);
					$title_segment = ucwords(str_replace('-', ' ', $title_segment));
					$eBulletinTitle = 'e-Bulletin Number ' . $title_segment;				

					$pdfFile = null;
					if($eBulletinURLs[5][$i]) {
						$pdfFileUrlSegments = parse_url($eBulletinURLs[5][$i]);
						$pdfFilePath = urldecode($pdfFileUrlSegments['path']);
						$pdfFilePath = str_replace(' ', '-', $pdfFilePath);

						if (DIRECTORY_SEPARATOR == '\\') {
							$fullLocalPathToNewPDF = $assetPath . str_replace('/', '\\', $pdfFilePath);						
						} else {
							$fullLocalPathToNewPDF = $assetPath . $pdfFilePath;
						}

						if( !file_exists($fullLocalPathToNewPDF) && ($pdfFileContents = file_get_contents($eBulletinURLs[5][$i])) !== false ) {							

								@mkdir(dirname($fullLocalPathToNewPDF), 0777, true);

								$fp = fopen($fullLocalPathToNewPDF, 'w');
								fwrite($fp, $pdfFileContents);
								fclose($fp);
						}

						$pdfFile = DataObject::get('File', array('"Filename" = ?' => 'assets/' . ltrim($pdfFilePath, '/')))->first();
						if(!$pdfFile) {
							$pdfFileSegments = pathinfo($pdfFileUrlSegments['path']);
							$pdfFile = File::create();
							$pdfFile->Title = $eBulletinTitle;
							$pdfFile->setFilename('assets/' . ltrim($pdfFilePath, '/'));
							$pdfFile->write();
						}						
					}

					$eBulletin = ResearchResource::create();
					$eBulletin->Title = $eBulletinTitle;
					$eBulletin->Description = $centerColumnDiv->ownerDocument->saveHTML($centerColumnDiv);
					$eBulletin->Author = 'NEDC';
					$eBulletin->isNEDC = true;
					$eBulletin->ArticleTypes()->push(DataObject::get('ResourceArticleType', '"Name" = \'e-Bulletin\'')->first());

					if($pdfFile) {
						$eBulletin->DownloadableFileID = $pdfFile->ID;
					}

					$eBulletin->write();
				}

				// break;
    		}
        }

        print sprintf('<p>Imported %s articles</p>', $importedCount);
    }	

	function file_get_contents_utf8($fn) {
	     $content = file_get_contents($fn);
	      return mb_convert_encoding($content, 'UTF-8',
	          mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
	}     
}