<?php

function tampil_alert($type, $title, $text)
{
  $CI = &get_instance();
  $data = array(
    'type'  => $type,
    'title' => $title,
    'text'  => $text
  );

  $CI->session->set_flashdata($data);
}
if (!function_exists('popup')) {
  function popup($judul, $pesan, $link)
  {
    $CI = &get_instance();
    $data = array(
      'judul' => $judul,
      'pesan' => $pesan,
      'link' => $link
    );
    $CI->session->set_flashdata($data);
  }
}
