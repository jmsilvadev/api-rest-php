<?php


class Analytics
{
    public $dao;

    public function __construct($dao)
    {
        $this->dao = $dao;
    }

    protected function getAnalysticsData(array $data): string
    {
        $url = $this->getRelatedUrl($data);
        $analyticsRelated = $this->dao->findFirstByUrl($url);
        if ($analyticsRelated) {
            $this->dao = $analyticsRelated;
            return $this->updateAnalyticsData($data);
        }
        return $this->createAnalyticsData($data);
    }

    protected function updateAnalyticsData(array $data): string
    {
        $this->dao->related = $this->getRelated($data);
        $this->dao->date_updated = date('Y-m-d H:i:s');
        if (!$this->dao->save())
        {
            return "Error on Saving";
        }

        return "OK\n";
    }

    protected function createAnalyticsData(array $data): string
    {
        $this->dao->related = $this->getRelated($data);
        $this->dao->date_updated = date('Y-m-d H:i:s');
        if (!$this->dao->save())
        {
            return "Error on Saving";
        }

        return "OK\n";
    }
}
