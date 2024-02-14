<?php

namespace Database\Factories;

use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seller>
 */
class SellerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        list($type, $imageData) = explode(';', "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFQAAABUCAYAAAAcaxDBAAAACXBIWXMAACxLAAAsSwGlPZapAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAxeSURBVHgB7V1rbBTXFT53Zne9u17bOC4BKmiDYiBEPEIdFwzYmEKCqlYUpUArNX0pbUiVKlFVVVUrVf2VqIqaVlUVFKXNn1KlUdP+4U9+8LBjQ8m7IaUhhNThKUIw+LHrfczr9pwZr7Nez/vO2iTaTxpmZ3buved+99xzzzl31jAIAA7AYFvvXvz3+3jVhZcp4Px9YOw5mCjtZydO3IBPIHh393xISD/C/lDf2vGWhndfAs4OsCP9zwepi/l9kO/Zk4CRj17AIjsdHtGQ8Wfx9AQ7cmwIPgHgvb3tEOM/Aybdj4qRdnjqIGjsu6y/f9RPnf4J3d77Dzx93cejKj79N9C1x1nf8TNwE4Jv614DIP0CZ9ZuvIx5l2DPscN93wIf8EUov7fnS2BIRyAIOOcgwT9B539kRwcG4CYAv2frFuDGI9jtr+BlQ6DChrHFTz98jA5CYw8jOcHAGEMTsBsktptv23IUCX4MBToKsww0VTKMDvciIb9EMntRsKA9sSCxH+C/noR6aij/MhpsVb4KAcyDc2UwiB37DfQNvMjMNa52QPuYBMnoAUn6FV5uAmH5uYKKtcDLlnprqCZ/DaIgE8xaukGWumF771vc4L+Dsdzz7I03VIgQvKMjDq2Z+/HjA6hWmyAysATIxl788IzrU+ABXIxexVOn0/eGYYCuG6bJpFlOhyxL5tkTnKM3wJ8AXXoWR14r3768atUSHOnWuFtRgJG2U6cuTl13dKRhXuZ72PBP8LIdPJvmKDvHs2GeJYnhIZtnFxxnh/s3uz3gWppv3bQC5Pi7dt+VSgrk80XQNN22bDwuQyIRN49YzGsi8IvI0G9HRnN9mqY9jTc2gg8wzl9Jx2IPp9uatyMzj+KdRY4tIIEkK8mtqpqL3DHIZFLOMjNjOTs0cNapHfeeyrEH7G5PTBRMMt2gqrp5TEwUcdQlaGhIQCrVYGqvjZRLUFf+QNoSBJyx9QXOX08Z4DgjiLxiUQFFUUxN9AI9PzKShaamNCSTNo6AwR7Cf3/qVN5DddjW6juKok4jkzSQRtVc1M1pZJkAem5KBrxXKBTNg4hNp5OoAfK0eklzqFxQUN3FYskcrOn1qWZ7RNCMXqGsiUQMB/fjKY6imzKUNTebzZv9omeqCve4iOO5KK2yE6aMpqZGHMWEbUEiV1E0U0gil64JdE0HCZtKJZFgy1KGIbMMXf94+hK5NODV9VmzJG4OKA2mnUbTQOfzBXNWWX2wa42vARd4EMrHkcJk5R0iorW1CQWSHKavBRLY6kDcJLOsMWUNIM1R1ZypKel0ykF4/6BBIlNUTSTNIBp0OvtZKEmWeDxuDoB9/6Rht/LuhHL2Ei5be2YUivmLB8qgjlCn6FBVy2SQ9hLorChZr9XVFWQjC4XStHtEIGkcKUBQuJcxXnb50jP+eQYiBo1+S0uTqeWknWX4WTCcwCvUm6Z0a2sztpEJRaZnQ8zY7/aIK6GYujqMvsnjUAOQlhOxLS2NrqbDL4i8efOaoLm5ccaCFxkYe4odGnTNaXj3ZNNWCt0ew+EJv2q4IJGwNIqmaFiQKamJRk4B+87gSdjc+6jXk4yUGE50/RyYvBYnnnOvrkjL4F22Gk6jsbsSTSRaiVyuYC5aYUAuUyaThkhBqvYZNCVrUY/uMF6HW/l5l6cpVByArhNPMf7ypqcxStkHQZDDYwhJPY2tXsDzuDjBNwWhGSTwdjqIRKo4oF3nxu8ZP7EZe8GD5QanVYLHZST0HB4f4DEkmRsIQTEnhJKFWIodWIYEYqwGi4UTYLmYEJkEUs7Fk8JQ2gD9TGOIg3qqBPGhFEhjtbJrITGfCJwk8TbuNyPsF5noe4s1FheMg9JSgkLXOBj7GyGRS5gLhl/nOkpYEZtqHkabAS2PJKGWiJxQpYhOe9Fyso2BOOjXOBSgNOV4k7tUzkSVcwCRy4DkUSRG0RnF+lN+6mWA/EEF0jsTUCtESqiZBBnPmp/5DQZG/0ynAdNz5kEEE5lEqhXPi9kvqo8ySpTh4i5xbP6QCokvxCC2WNz3tUOktRayuanO6H9Pesbn5elImZ3q0DFQu1g2l8ubYSz3aJSrHCZeUKBWiIxQDYnRSpNT/d8x4Fdm11YGgXIGc6THQrgiPhDZlC9ks5Z2KDjV+8JHPZUgd6g6jKRslYg2l5F/UYGGtZjGa4p24CMhtFTAtJlmjbhxNAF8TFxICicbG1O2ixbZalpwRKBfNyB/RIXGXdEuUMJTnlPGPDdhfmZjOOKvibm1BMpFkqPu5AFkMtEkVJR+9EUnIFIIayhpJ5FKSL2GKbnWRlODym4L5T+DpuZoJ8DNnaLcKRE+NpaDIKBylD6ktCGl+cw2+lD2r+oQFYQIJeIUJJRAEVH8PSv8K2/K0UGgLLq126h6ujWUFK7MkzqB/FiysW72tOyWUX1EpG1a7xXU9M1I6DyIBEKEKrj/YkxuOSRfxW0Rw16raHoSUfiUSSZpbzl6qdyyoIGgfSa/IBtbXQe1Vd6+9h04HEaid0ejpTFrKyp4uGIuDJPaKV8n7Uz5KmftOMan8p/WrqW125hqawBJ9S8K1ZW+NQnqiGZGYDQjQm2lnEQt3R6NlkrApPchBJQK25l4C7WTh1vZSStJe5t7cHPs88Ez7fISA5LrJHP6i+xLQV8kWf5zuLUHD+KH8UDFKMKZTLVJOYzLz/rTTkeQsm4LvyFQ6BkDHhNMvb3DrDxvaDA05voPY6zzWD8f6G6HGFtWqWYToyMHUAOX2hU1X2iY3AtPnEL3RhPzO0sdOVCNPOgjDejD+neHiEIpi+FmWofiF7OQ+lczhEaRgTqgQmmDD1YZDGda23ZNXWtcw8TdGbbu2Ki5KLGewWt4ulZZZvTgcs493B2m4AJwRixTbmQwDFw7bsbYmiIDV4L5l1LJAJqsyqocJE+iuzURfurKbzeAvnoUeMKj3wz3KLoGj9t9J+Qdxy7hIpAVc2VL6yaAx8VfFSUSimuE5ixIOBjyBbHARIjQhjczIAKjUYeSIAmVUNZMoMaLuT/Jk2J9Ck2odA0d5Q/FRrN4dzaqV3lNkKaX7sqCCOSrCYh9FD65E5rQxHuCtjOJUdbKPEQNZSW6c8nwHgMFJ/Kl8IriaACb29rc584FsRQdW4/7O4vapt3j83FBGQu4qCzUgc2vmqadSOhgeGuW+m8zJHe4RGycfjpk/86tI6EYhRiOARTtxV8XML9YlG3g5NVPb5PexQzqnFPWSapa1DrxmtbgsIqK6Ud2CWX5nMNi6SJiOFbeFjR8y7GnYrbfHa14tAu+OXQ6ZOQHYXBWMBfZWZPXpKbjbsE2ToX8ORMExYc4cjcENPQWnEbtNf2JkoWV2EaTQDuj2MdLwfsZnNB3BKf7nTzivVYXiM6ED2aD0CFBQle7dDJqxV0mWOF/ak0oJZguCqgXvR64aBamexn0vlWbQHvDwV98C8YOvWEnMovu5JFGRr6wXIBQ2lg9H0zgYIReFmTj9llY3auxQrDNmhJ63uFxCm52YGDV7RJc0cusn53F6V4GTXu3F2d7dUt2J94CEuo/90YyXbSpvBW/+I5u2UfaYnpTtt/rXshpj272QWH5YrCPFBtRpo2owbThsAI//1We6RLSmsF136bKv4YOs5kGugcbekizyCSQYNsctPSOOZjuZTiZmu2TZBLoRdwfY186q8gjOzrsX0v9E/q/ikppu30vNnwPClSddCLfb7FNBxbC3MHuVW+6Vx1NUb5nJ967T5/+BzTOgW/4J3Rs8kxuyIOauz+5y5huTFKz7C5V41ZuTe9K3Odi7+9C+fdhH+dNlqmJhl6RrBVzHwqywIMc+n69Pv26di8Ne4OmdWWmkPbg53v0gb4nUm/DPl+tBaGLsOJv6v5/akLmoCz0LTD3KCsBybTBZx8oI/Zt3VqwfMI/oTuMYC/ukCv1Dd3SzKVzuCCVsWjyFx97yD4GMD8kf5d/+WubpiCtuFe38pNzDXLbyN+ssS2v/Y+IOozZyy65gYhcUvuFsfaE3iy/+5olOW4G3flUoU5oxKgTGjHqhEaMOqERo05oxKgTGjHqhEaMOqERo05oxKgTGjHqhEaMOqERo05oxKgTGjHqhEaMOqERo05oxKgTGgaG85+kcCGUXYU67MHA8T/iciZUhgNQhz0k9henr5x/+LX++J/58Y1FLPxrYM7/JUSkkHkDyIFf6tVRvtr8mbBKGMBB4peBS0+y9YN/cnrs/7BpwiU8mR6PAAAAAElFTkSuQmCC");
        list(,$extension) = explode('/',$type);
        list(,$imageData)      = explode(',', $imageData);
        $fileName = uniqid().'.'.$extension;
        $imageData = base64_decode($imageData);

        Storage::disk("public")->put("logo/".$fileName,$imageData);


        return [
            "phone"=>$this->faker->phoneNumber,
            "email"=>$this->faker->unique()->email,
            "shop_name"=>$this->faker->name,
            "business_type_id"=>1,
            "logo"=>$fileName,
            "password"=>Hash::make("123456"),
            "address"=>$this->faker->address,
            "slug"=>$this->faker->slug,
            "country"=>"Bangladesh",
        ];
    }
}
