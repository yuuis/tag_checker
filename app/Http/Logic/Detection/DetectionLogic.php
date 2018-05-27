<?php

namespace App\Http\Logic\Detection;

use Illuminate\Http\Request;
use App\Http\Logic\BaseLogic;
use App\Http\Logic\LogicResultDTO;
use ZipArchive;

class DetectionLogic extends \App\Http\Logic\BaseLogic {
    public function __construct() {
    }

    /**
     * @param Request $request
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function validateDetectionLogSid(Request $request, $detectionLogSid) {
        \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();
        $detectionDao = new \App\Http\Model\DetectionDAO();
        $result = $detectionDao->checkExsistSid($detectionLogSid);
        if($result === "exist") {
            $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
        } else {
            $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::FAILURE);
        }
        return $resultDTO;
    }

    /**
     * @param Request $request
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function fetchHistory(Request $request, $keywordSid) {
        \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();
        $detectionDao = new \App\Http\Model\DetectionDAO();
        $results = $detectionDao->selectHistoryForSid($keywordSid);
        \Log::debug(__METHOD__."---results--->".print_r($results, true));
        if(!empty($results)) {
            $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
            $resultDTO->setResults($results);
        } else {
            $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::FAILURE);
        }
        return $resultDTO;
    }

    /**
     * @param Request $request
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function fetchDetail(Request $request, $detectionLogSid) {
        \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();
        $detectionDao = new \App\Http\Model\DetectionDAO();
        $results = $detectionDao->selectDetailForSid($detectionLogSid);
        $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
        $resultDTO->setResults($results);
        return $resultDTO;
    }


    public function writeLog($keywordSid, $keyword, $date, $strangeUrls = null, $screenShot = null) {
        \Log::info(__METHOD__);
        $detectionDao = new \App\Http\Model\DetectionDAO();
        if($strangeUrls === null) {
            // 正常
            $detectionDao->insertNomalLog($keywordSid, $keyword, $date);
            $detectionDao->updateNomalLog($keywordSid, $keyword, $date);
        } else {
            // 異常
            $detectionLogSid = $detectionDao->insertAbnomalLog($keywordSid, $keyword, $date, $strangeUrls, $screenShot);
            $detectionDao->updateAbnomalLog($keywordSid, $keyword, $date, $strangeUrls, $screenShot);
            return $detectionLogSid;
        }
    }

    public function downloadImage($detectionLogSid) {
        \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();
        $detectionDao = new \App\Http\Model\DetectionDAO();
        $imagePath = $detectionDao->selectImagePath($detectionLogSid);

        $zip = new \ZipArchive();
        $zipFileName = "キャプチャ.zip";
        $zipTmpDir = "/tmp/";
         
        $image = array();
        if(!empty($imagePath[0]->image_url_google_pc)){ $image[] = $imagePath[0]->image_url_google_pc; }
        if(!empty($imagePath[0]->image_url_google_sp)){ $image[] = $imagePath[0]->image_url_google_sp; }
        if(!empty($imagePath[0]->image_url_yahoo_pc)){ $image[] = $imagePath[0]->image_url_yahoo_pc; }
        if(!empty($imagePath[0]->image_url_yahoo_sp)){ $image[] = $imagePath[0]->image_url_yahoo_sp; }
        set_time_limit(0);

        if(!empty($image)){
            $result = $zip->open($zipTmpDir.$zipFileName, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
            if ($result === true) {
                \Log::debug(__METHOD__."===fuag===");
                foreach ($image as $filepath) {
                    $filename = basename($filepath);
                    $zip->addFromString($filename,file_get_contents($filepath));
                }
                $zip->close();
                header('Content-Type: application/zip; name="' . $zipFileName . '"');
                header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
                header('Content-Length: '.filesize($zipTmpDir.$zipFileName));
                echo file_get_contents($zipTmpDir.$zipFileName);
                unlink($zipTmpDir.$zipFileName);
                exit();
            } else {
                return $resultDTO;
            }
        } else {
            return $resultDTO;
        }
    }
    
}