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
        if (isset($this->wallet_transfer_method) && isset($this->transfer_type_value) && $this->wallet_transfer_method == "wallet_number") {
            $citizen = CitizenWallet::where("wallet_number", $this->transfer_type_value)->pluck("citizen_id")->first();
            $this->sending_to_himself($citizen);
        } //check if citizen is sending to himself


        $tt = join(",", Transfer::WALLET_TRANSFER_METHODS);
        $rules = [
            "amount" => ["required", 'regex:/^\d{1,5}+(\.\d{1,2})?$/'],
            "wallet_transfer_method" => ["required", "in:" . $tt],
        ];
        if (isset($this->wallet_transfer_method)) { // filling wallet_transfer_method validation
            if (isset($map[$this->wallet_transfer_method]))
                $rules += ["transfer_type_value" => $map[$this->wallet_transfer_method]];
        }
        if (isset($this->wallet_transfer_method) && isset($this->transfer_type_value)) {

            if (in_array($this->wallet_transfer_method, ["phone", "identity_number"])) {
                $citizen = User::where($this->wallet_transfer_method, $this->transfer_type_value)->where("user_type", "citizen")->pluck("id")->first();
                if ($citizen) {
                    $rules += ["transfer_status" => ["nullable", "in:accepted"]]; //  if receiver existed

                    $this->sending_to_himself($citizen); //check if citizen is sending to himself
                } else $rules += ["transfer_status" => ["required", "in:accepted,holding"]]; //  if receiver not existed
            } else   $rules += ["transfer_status" => ["nullable", "in:accepted"]];

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
        if ($citizen && $citizen == auth()->id()) {
            $rules = ["wallet_transfer_method" => []];
            array_push($rules  ["wallet_transfer_method"], function ($attribute, $value, $fail) {
                $fail(trans("dashboard.citizen.same_citizen_transfer"));
            });
            return $rules;
        }
    }
}

