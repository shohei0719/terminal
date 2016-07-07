<?php

use Phalcon\Tag;

class MyTags extends Tag
{
  static public function errorMsg($message)
  {
    return '<div class="alert alert-danger">' . $message . '</div>';
  }

  static public function getVersion($id)
  {
    $version = new Versions();
    return $version->getVersionInfo($id)->name;
  }

  static public function getOrganization($id)
  {
    $organization = new Organizations();
    return $organization->getOrganizationInfo($id)->name;
  }

  static public function getOs($id)
  {
    $os = new Oss();
    return $os->getOsInfo($id)->name;
  }

  static public function getMaker($id)
  {
    $maker = new Makers();
    return $maker->getMakerInfo($id)->name;
  }

  static public function getCarriers($id)
  {
    $carrier = new Carriers();
    return $carrier->getCarrierInfo($id)->name;
  }
}
