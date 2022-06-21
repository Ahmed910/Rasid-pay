<html>

<head>
  <meta charset="utf-8" />
  <title>Tax Invoice</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: "cairo", Times, serif;
    }

    .table-bordered td,
    .table-bordered th {
      border: 1px solid #ddd;
      padding: 10px;
      word-break: break-all;
    }

    body {
      margin: 0;
      padding: 0;
      font-size: 16px;
    }

    .h4-14 h4 {
      font-size: 12px;
      margin-top: 0;
      margin-bottom: 5px;
    }

    .img {
      margin-left: "auto";
      margin-top: "auto";
      height: 30px;
    }

    pre,
    p {
      /* width: 99%; */
      /* overflow: auto; */
      /* bpicklist: 1px solid #aaa; */
      padding: 0;
      margin: 0;
    }

    table {
      font-family: arial, sans-serif;
      width: 100%;
      border-collapse: collapse;
      padding: 1px;
    }

    tr {
      border-bottom: 1px solid gray;
    }

    .hm-p p {
      text-align: left;
      padding: 1px;
      padding: 5px 4px;
    }

    td,
    th {
      text-align: left;
      padding: 8px 6px;
    }

    .table-b td,
    .table-b th {
      border: 1px solid #ddd;
    }

    th {
      /* background-color: #ddd; */
      text-align: right;
    }

    .hm-p td,
    .hm-p th {
      padding: 3px 0px;
    }

    .cropped {
      float: right;
      margin-bottom: 20px;
      height: 100px;
      /* height of container */
      overflow: hidden;
    }

    .cropped img {
      width: 400px;
      margin: 8px 0px 0px 80px;
    }

    .main-pd-wrapper {
      box-shadow: 0 0 10px #ddd;
      background-color: #fff;
      border-radius: 10px;
      padding: 15px;
    }

    .table-bordered td,
    .table-bordered th {
      border: 1px solid #ddd;
      padding: 10px;
      font-size: 14px;
    }

    .invoice-items {
      font-size: 14px;
      border-top: 1px dashed #ddd;
    }

    .invoice-items td {
      padding: 14px 0;

    }
  </style>
</head>

<body dir="rtl">
  <section class="main-pd-wrapper" style="width: 450px; margin: auto">
    <div style="
                  text-align: center;
                  margin: auto;
                  line-height: 1.5;
                  font-size: 14px;
                  color: #4a4a4a;
                ">

      <p style="font-weight: bold; color: blue; margin-top: 15px; font-size: 18px;">
        تم التحويل بنجاح
      </p>
    </div>
    <table style="width: 100%; table-layout: fixed;margin-top:30px;">
      <thead>
        <tr>
          <th style="width: 220px;color:blue;">نوع العملية</th>
          <th>{{ $transaction->trans_type ?? '' }}</th>
        </tr>
        <tr>
          <th style="width: 220px;color:blue;">تاريخ العملية</th>
          <th>{{ $transaction->created_at ?? '' }}</th>
        </tr>
        <tr>
          <th style="width: 220px;color:blue;">رقم MTCN</th>
          <th>#{{ $transaction?->transactionable->transfer_type ?? '' }}</th>
        </tr>
        <tr>
          <th style="width: 220px;color:blue;">الرقم المرجعي</th>
          <th>#{{ $transaction->trans_number ?? '' }}</th>
        </tr>
        <tr>
          <th style="width: 220px;color:blue;">مبلغ التحويل</th>
          <th>{{ $transaction->amount ?? '' }} (USD)</th>
        </tr>
        <tr>
          <th style="width: 220px;color:blue;">رسوم التحويل</th>
          <th>{{ $transaction->fee_amount ?? '' }} ر.س</th>
        </tr>
        <tr>
          <th style="width: 220px;color:blue;">سعر الصرف</th>
          <th>0</th>
        </tr>
        <tr>
          <th style="width: 220px;color:blue;">من حساب رقم</th>
          <th>{{ $transaction?->fromUser->fullname ?? '' }}</th>
        </tr>
        <tr>
          <th style="width: 220px;color:blue;">إجمالي المبلغ</th>
          <th>{{ $transaction->trans_number ?? '' }} ر.س</th>
        </tr>
        <tr>
          <th style="width: 220px;color:blue;">اسم المستفيد</th>
          <th> {{ $transaction?->toUser->fullname }}</th>
        </tr>
        <tr>
          <th style="width: 220px;color:blue;">عنوان المستفيد</th>
          <th></th>
        </tr>
        <tr>
          <th style="width: 220px;color:blue;">الغرض من الحوالة</th>
          <th> {{ $transaction?->transactionable?->bankTransfer?->transferPurpose->name  ?? '' }} </th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </section>
</body>

</html>
