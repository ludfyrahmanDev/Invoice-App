<?php

namespace App\Constants;

class FormType
{
    public const type = ['text' => '<input disabled placeholder=Opsi type=text class=form-control />', 'email' => '<input disabled placeholder=Opsi type=email class=form-control />', 'number' => '<input disabled placeholder=Opsi type=number class=form-control />', 'date' => '<input disabled placeholder=Opsi type=date class=form-control />', 'radio-range' => '<input type=radio /> Opsi 1', 'select' => '<select disabled placeholder=Opsi class=form-control><option>Pilih opsi</option></select>', 'textarea' => '<textarea disabled placeholder=Opsi type=email class=form-control rows=5 />'];
}
