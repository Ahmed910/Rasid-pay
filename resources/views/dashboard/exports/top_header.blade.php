<!DOCTYPE html>
<html lang="en" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
  <!-- META DATA -->
  <meta charset="UTF-8" />
  <style>
    @media screen,
    print {
      * {
        -webkit-print-color-adjust: exact;
        font-family: "cairo", Times, serif;
      }

      table {
        font-family: 'cairo', sans-serif;
        width: 100%;
        background-position: center center;
      }

      h3 {
        font-weight: bold
      }

      table th {
        /* text-align: center !important; */
        padding: 15px
      }

      .active {
        color: #04A777
      }

      .unactive {
        color: #e23e3d
      }
/*
      table {
        border-collapse: collapse;
      } */


      table th {
        border: 1px solid #c9c9c9 !important;
      }

      table td {
        padding: 15px
      }

      .header {
        width: 100%;
        position: relative;
      }

      .logo {
        width: 10px;
      }

      img {
        border-radius: 10px !important
      }

      .title {
        width: 50%;
        display: block;
        float: left;
      }
    }
  </style>
</head>

<body class="app sidebar-mini {{ LaravelLocalization::getCurrentLocaleDirection() }}">
  <table id="departmentTable" class="table">
    <thead>
      @include('dashboard.exports.header',['topic'=>trans('dashboard.bank.banks'), 'count' => 1])
      <tr>
        <th>#</th>
        <th> @lang('dashboard.bank.name')</th>
        <th> @lang('dashboard.bank.status') </th>
      </tr>
    </thead>
    <tbody>