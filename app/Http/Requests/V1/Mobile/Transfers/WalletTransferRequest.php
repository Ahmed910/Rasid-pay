<?php

namespace App\Http\Requests\V1\Mobile\Transfers;

use App\Http\Requests\ApiMasterRequest;
use App\Models\CitizenWallet;
use App\Models\Transfer;
use App\Models\User;

class WalletTransferRequest extends ApiMasterRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */


    public function rules()
    {
        $map = [
            "identity_number" => "required|numeric|not_regex:/^0/|digits_between:10,20|exists:users,identity_number,user_type,citizen",
            "wallet_number" => "required|exists:citizen_wallets,wallet_number",
            "phone" => ["required", "starts_with:5", "numeric", "digits_between:5,9"]
        ];

        $tt = join(",", Transfer::WALLET_TRANSFER_METHODS);
        $rules = [
            "amount" => ["required", 'regex:/^\d{1,5}+(\.\d{1,2})?$/'],
            "wallet_transfer_method" => ["required", "in:" . $tt],
        ];

        //check if citizen is sending to himself or in black list
        if (isset($this->wallet_transfer_method) && isset($this->transfer_type_value) && $this->wallet_transfer_method == "wallet_number") {
            $citizen = CitizenWallet::where("wallet_number", $this->transfer_type_value)->select("citizen_id")->with("citizen:id,in_black_list")->first();
            if ($citizen == null) return ["transfer_type_value" => function ($attribute, $value, $fail) {
                $fail(trans("validation.exists"));
            }];
            $citizen = $citizen->citizen;
            $res = $this->in_black_list($citizen);
            if (count($res)) return $res;
            $res = $this->sending_to_himself($citizen);
            if (count($res  ["transfer_type_value"])) return $res;
        }


        // filling wallet_transfer_method validation
        if (isset($this->wallet_transfer_method)) {
            if (isset($map[$this->wallet_transfer_method]))
                $rules += ["transfer_type_value" => $map[$this->wallet_transfer_method]];
        }

        // filling transfer_status validation
        if (isset($this->wallet_transfer_method) && isset($this->transfer_type_value)) {

            if (in_array($this->wallet_transfer_method, ["phone", "identity_number"])) {
                $citizen = User::where($this->wallet_transfer_method, $this->transfer_type_value)->where("user_type", "citizen")->select("id", "in_black_list")->first();
                if ($citizen) {
                    $rules += ["transfer_status" => ["nullable", "in:accepted"]]; //  if receiver existed

                    //check if citizen is sending to himself or in_black_list
                    $res = $this->in_black_list($citizen);
                    if (count($res)) return $res;
                    $res = $this->sending_to_himself($citizen);
                    if (count($res  ["transfer_type_value"])) return $res;

                } else $rules += ["transfer_status" => ["required", "in:accepted,holding"]]; //  if receiver not existed
            } else   $rules += ["transfer_status" => ["nullable", "in:accepted"]];  // method is wallet number

        }
        return $rules;
    }

    public function receiverexisted()
    {

    }

    public function receiver_not_existed()
    {

    }

    public function sending_to_himself($citizen)
    {
        $rules = ["transfer_type_value" => []];
        if ($citizen && $citizen->id == auth()->id()) {
            array_push($rules  ["transfer_type_value"], function ($attribute, $value, $fail) {
                $fail(trans("dashboard.citizen.same_citizen_transfer"));
            });

        }
        return $rules;
    }

    public function in_black_list($citizen)
    {
        $r = [];
        if ($citizen->in_black_list) {
            $r = ["transfer_type_value" => function ($attribute, $value, $fail) {
                $fail(trans("dashboard.citizen.wallet_in_black_list"));
            }];

        }
        return $r;
    }


}

