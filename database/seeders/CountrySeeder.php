<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $contryArr = [
            [
                "name" => "Afghanistan",
                "code" => "AF",
                "iso3" => "AFG",
                "numeric_code" => 4,
                "latitude" => 33,
                "longitude" => 65,
                "emoji_flag" => "🇦🇫"
            ],
            [
                "name" => "Albania",
                "code" => "AL",
                "iso3" => "ALB",
                "numeric_code" => 8,
                "latitude" => 41,
                "longitude" => 20,
                "emoji_flag" => "🇦🇱"
            ],
            [
                "name" => "Algeria",
                "code" => "DZ",
                "iso3" => "DZA",
                "numeric_code" => 12,
                "latitude" => 28,
                "longitude" => 3,
                "emoji_flag" => "🇩🇿"
            ],
            [
                "name" => "American Samoa",
                "code" => "AS",
                "iso3" => "ASM",
                "numeric_code" => 16,
                "latitude" => -14.3333,
                "longitude" => -170,
                "emoji_flag" => "🇦🇸"
            ],
            [
                "name" => "Andorra",
                "code" => "AD",
                "iso3" => "AND",
                "numeric_code" => 20,
                "latitude" => 42.5,
                "longitude" => 1.6,
                "emoji_flag" => "🇦🇩"
            ],
            [
                "name" => "Angola",
                "code" => "AO",
                "iso3" => "AGO",
                "numeric_code" => 24,
                "latitude" => -12.5,
                "longitude" => 18.5,
                "emoji_flag" => "🇦🇴"
            ],
            [
                "name" => "Anguilla",
                "code" => "AI",
                "iso3" => "AIA",
                "numeric_code" => 660,
                "latitude" => 18.25,
                "longitude" => -63.1667,
                "emoji_flag" => "🇦🇮"
            ],
            [
                "name" => "Antarctica",
                "code" => "AQ",
                "iso3" => "ATA",
                "numeric_code" => 10,
                "latitude" => -90,
                "longitude" => 0,
                "emoji_flag" => "🇦🇶"
            ],
            [
                "name" => "Antigua and Barbuda",
                "code" => "AG",
                "iso3" => "ATG",
                "numeric_code" => 28,
                "latitude" => 17.05,
                "longitude" => -61.8,
                "emoji_flag" => "🇦🇬"
            ],
            [
                "name" => "Argentina",
                "code" => "AR",
                "iso3" => "ARG",
                "numeric_code" => 32,
                "latitude" => -34,
                "longitude" => -64,
                "emoji_flag" => "🇦🇷"
            ],
            [
                "name" => "Armenia",
                "code" => "AM",
                "iso3" => "ARM",
                "numeric_code" => 51,
                "latitude" => 40,
                "longitude" => 45,
                "emoji_flag" => "🇦🇲"
            ],
            [
                "name" => "Aruba",
                "code" => "AW",
                "iso3" => "ABW",
                "numeric_code" => 533,
                "latitude" => 12.5,
                "longitude" => -69.9667,
                "emoji_flag" => "🇦🇼"
            ],
            [
                "name" => "Australia",
                "code" => "AU",
                "iso3" => "AUS",
                "numeric_code" => 36,
                "latitude" => -27,
                "longitude" => 133,
                "emoji_flag" => "🇦🇺"
            ],
            [
                "name" => "Austria",
                "code" => "AT",
                "iso3" => "AUT",
                "numeric_code" => 40,
                "latitude" => 47.3333,
                "longitude" => 13.3333,
                "emoji_flag" => "🇦🇹"
            ],
            [
                "name" => "Azerbaijan",
                "code" => "AZ",
                "iso3" => "AZE",
                "numeric_code" => 31,
                "latitude" => 40.5,
                "longitude" => 47.5,
                "emoji_flag" => "🇦🇿"
            ],
            [
                "name" => "Bahamas",
                "code" => "BS",
                "iso3" => "BHS",
                "numeric_code" => 44,
                "latitude" => 24.25,
                "longitude" => -76,
                "emoji_flag" => "🇧🇸"
            ],
            [
                "name" => "Bahrain",
                "code" => "BH",
                "iso3" => "BHR",
                "numeric_code" => 48,
                "latitude" => 26,
                "longitude" => 50.55,
                "emoji_flag" => "🇧🇭"
            ],
            [
                "name" => "Bangladesh",
                "code" => "BD",
                "iso3" => "BGD",
                "numeric_code" => 50,
                "latitude" => 24,
                "longitude" => 90,
                "emoji_flag" => "🇧🇩"
            ],
            [
                "name" => "Barbados",
                "code" => "BB",
                "iso3" => "BRB",
                "numeric_code" => 52,
                "latitude" => 13.1667,
                "longitude" => -59.5333,
                "emoji_flag" => "🇧🇧"
            ],
            [
                "name" => "Belarus",
                "code" => "BY",
                "iso3" => "BLR",
                "numeric_code" => 112,
                "latitude" => 53,
                "longitude" => 28,
                "emoji_flag" => "🇧🇾"
            ],
            [
                "name" => "Belgium",
                "code" => "BE",
                "iso3" => "BEL",
                "numeric_code" => 56,
                "latitude" => 50.8333,
                "longitude" => 4,
                "emoji_flag" => "🇧🇪"
            ],
            [
                "name" => "Belize",
                "code" => "BZ",
                "iso3" => "BLZ",
                "numeric_code" => 84,
                "latitude" => 17.25,
                "longitude" => -88.75,
                "emoji_flag" => "🇧🇿"
            ],
            [
                "name" => "Benin",
                "code" => "BJ",
                "iso3" => "BEN",
                "numeric_code" => 204,
                "latitude" => 9.5,
                "longitude" => 2.25,
                "emoji_flag" => "🇧🇯"
            ],
            [
                "name" => "Bermuda",
                "code" => "BM",
                "iso3" => "BMU",
                "numeric_code" => 60,
                "latitude" => 32.3333,
                "longitude" => -64.75,
                "emoji_flag" => "🇧🇲"
            ],
            [
                "name" => "Bhutan",
                "code" => "BT",
                "iso3" => "BTN",
                "numeric_code" => 64,
                "latitude" => 27.5,
                "longitude" => 90.5,
                "emoji_flag" => "🇧🇹"
            ],
            [
                "name" => "Bolivia",
                "code" => "BO",
                "iso3" => "BOL",
                "numeric_code" => 68,
                "latitude" => -17,
                "longitude" => -65,
                "emoji_flag" => "🇧🇴"
            ],
            [
                "name" => "Bosnia and Herzegovina",
                "code" => "BA",
                "iso3" => "BIH",
                "numeric_code" => 70,
                "latitude" => 44,
                "longitude" => 18,
                "emoji_flag" => "🇧🇦"
            ],
            [
                "name" => "Botswana",
                "code" => "BW",
                "iso3" => "BWA",
                "numeric_code" => 72,
                "latitude" => -22,
                "longitude" => 24,
                "emoji_flag" => "🇧🇼"
            ],
            [
                "name" => "Bouvet Island",
                "code" => "BV",
                "iso3" => "BVT",
                "numeric_code" => 74,
                "latitude" => -54.4333,
                "longitude" => 3.4,
                "emoji_flag" => "🇧🇻"
            ],
            [
                "name" => "Brazil",
                "code" => "BR",
                "iso3" => "BRA",
                "numeric_code" => 76,
                "latitude" => -10,
                "longitude" => -55,
                "emoji_flag" => "🇧🇷"
            ],
            [
                "name" => "British Indian Ocean Territory",
                "code" => "IO",
                "iso3" => "IOT",
                "numeric_code" => 86,
                "latitude" => -6,
                "longitude" => 71.5,
                "emoji_flag" => "🇮🇴"
            ],
            [
                "name" => "Brunei",
                "code" => "BN",
                "iso3" => "BRN",
                "numeric_code" => 96,
                "latitude" => 4.5,
                "longitude" => 114.6667,
                "emoji_flag" => "🇧🇳"
            ],
            [
                "name" => "Bulgaria",
                "code" => "BG",
                "iso3" => "BGR",
                "numeric_code" => 100,
                "latitude" => 43,
                "longitude" => 25,
                "emoji_flag" => "🇧🇬"
            ],
            [
                "name" => "Burkina Faso",
                "code" => "BF",
                "iso3" => "BFA",
                "numeric_code" => 854,
                "latitude" => 13,
                "longitude" => -2,
                "emoji_flag" => "🇧🇫"
            ],
            [
                "name" => "Burundi",
                "code" => "BI",
                "iso3" => "BDI",
                "numeric_code" => 108,
                "latitude" => -3.5,
                "longitude" => 30,
                "emoji_flag" => "🇧🇮"
            ],
            [
                "name" => "Cambodia",
                "code" => "KH",
                "iso3" => "KHM",
                "numeric_code" => 116,
                "latitude" => 13,
                "longitude" => 105,
                "emoji_flag" => "🇰🇭"
            ],
            [
                "name" => "Cameroon",
                "code" => "CM",
                "iso3" => "CMR",
                "numeric_code" => 120,
                "latitude" => 6,
                "longitude" => 12,
                "emoji_flag" => "🇨🇲"
            ],
            [
                "name" => "Canada",
                "code" => "CA",
                "iso3" => "CAN",
                "numeric_code" => 124,
                "latitude" => 60,
                "longitude" => -95,
                "emoji_flag" => "🇨🇦"
            ],
            [
                "name" => "Cape Verde",
                "code" => "CV",
                "iso3" => "CPV",
                "numeric_code" => 132,
                "latitude" => 16,
                "longitude" => -24,
                "emoji_flag" => "🇨🇻"
            ],
            [
                "name" => "Cayman Islands",
                "code" => "KY",
                "iso3" => "CYM",
                "numeric_code" => 136,
                "latitude" => 19.5,
                "longitude" => -80.5,
                "emoji_flag" => "🇰🇾"
            ],
            [
                "name" => "Central African Republic",
                "code" => "CF",
                "iso3" => "CAF",
                "numeric_code" => 140,
                "latitude" => 7,
                "longitude" => 21,
                "emoji_flag" => "🇨🇫"
            ],
            [
                "name" => "Chad",
                "code" => "TD",
                "iso3" => "TCD",
                "numeric_code" => 148,
                "latitude" => 15,
                "longitude" => 19,
                "emoji_flag" => "🇹🇩"
            ],
            [
                "name" => "Chile",
                "code" => "CL",
                "iso3" => "CHL",
                "numeric_code" => 152,
                "latitude" => -30,
                "longitude" => -71,
                "emoji_flag" => "🇨🇱"
            ],
            [
                "name" => "China",
                "code" => "CN",
                "iso3" => "CHN",
                "numeric_code" => 156,
                "latitude" => 35,
                "longitude" => 105,
                "emoji_flag" => "🇨🇳"
            ],
            [
                "name" => "Christmas Island",
                "code" => "CX",
                "iso3" => "CXR",
                "numeric_code" => 162,
                "latitude" => -10.5,
                "longitude" => 105.6667,
                "emoji_flag" => "🇨🇽"
            ],
            [
                "name" => "Cocos (Keeling) Islands",
                "code" => "CC",
                "iso3" => "CCK",
                "numeric_code" => 166,
                "latitude" => -12.5,
                "longitude" => 96.8333,
                "emoji_flag" => "🇨🇨"
            ],
            [
                "name" => "Colombia",
                "code" => "CO",
                "iso3" => "COL",
                "numeric_code" => 170,
                "latitude" => 4,
                "longitude" => -72,
                "emoji_flag" => "🇨🇴"
            ],
            [
                "name" => "Comoros",
                "code" => "KM",
                "iso3" => "COM",
                "numeric_code" => 174,
                "latitude" => -12.1667,
                "longitude" => 44.25,
                "emoji_flag" => "🇰🇲"
            ],
            [
                "name" => "Congo",
                "code" => "CG",
                "iso3" => "COG",
                "numeric_code" => 178,
                "latitude" => -1,
                "longitude" => 15,
                "emoji_flag" => "🇨🇬"
            ],
            [
                "name" => "Congo, the Democratic Republic of the",
                "code" => "CD",
                "iso3" => "COD",
                "numeric_code" => 180,
                "latitude" => 0,
                "longitude" => 25,
                "emoji_flag" => "🇨🇩"
            ],
            [
                "name" => "Cook Islands",
                "code" => "CK",
                "iso3" => "COK",
                "numeric_code" => 184,
                "latitude" => -21.2333,
                "longitude" => -159.7667,
                "emoji_flag" => "🇨🇰"
            ],
            [
                "name" => "Costa Rica",
                "code" => "CR",
                "iso3" => "CRI",
                "numeric_code" => 188,
                "latitude" => 10,
                "longitude" => -84,
                "emoji_flag" => "🇨🇷"
            ],
            [
                "name" => "Ivory Coast",
                "code" => "CI",
                "iso3" => "CIV",
                "numeric_code" => 384,
                "latitude" => 8,
                "longitude" => -5,
                "emoji_flag" => "🇨🇮"
            ],
            [
                "name" => "Croatia",
                "code" => "HR",
                "iso3" => "HRV",
                "numeric_code" => 191,
                "latitude" => 45.1667,
                "longitude" => 15.5,
                "emoji_flag" => "🇭🇷"
            ],
            [
                "name" => "Cuba",
                "code" => "CU",
                "iso3" => "CUB",
                "numeric_code" => 192,
                "latitude" => 21.5,
                "longitude" => -80,
                "emoji_flag" => "🇨🇺"
            ],
            [
                "name" => "Cyprus",
                "code" => "CY",
                "iso3" => "CYP",
                "numeric_code" => 196,
                "latitude" => 35,
                "longitude" => 33,
                "emoji_flag" => "🇨🇾"
            ],
            [
                "name" => "Czech Republic",
                "code" => "CZ",
                "iso3" => "CZE",
                "numeric_code" => 203,
                "latitude" => 49.75,
                "longitude" => 15.5,
                "emoji_flag" => "🇨🇿"
            ],
            [
                "name" => "Denmark",
                "code" => "DK",
                "iso3" => "DNK",
                "numeric_code" => 208,
                "latitude" => 56,
                "longitude" => 10,
                "emoji_flag" => "🇩🇰"
            ],
            [
                "name" => "Djibouti",
                "code" => "DJ",
                "iso3" => "DJI",
                "numeric_code" => 262,
                "latitude" => 11.5,
                "longitude" => 43,
                "emoji_flag" => "🇩🇯"
            ],
            [
                "name" => "Dominica",
                "code" => "DM",
                "iso3" => "DMA",
                "numeric_code" => 212,
                "latitude" => 15.4167,
                "longitude" => -61.3333,
                "emoji_flag" => "🇩🇲"
            ],
            [
                "name" => "Dominican Republic",
                "code" => "DO",
                "iso3" => "DOM",
                "numeric_code" => 214,
                "latitude" => 19,
                "longitude" => -70.6667,
                "emoji_flag" => "🇩🇴"
            ],
            [
                "name" => "Ecuador",
                "code" => "EC",
                "iso3" => "ECU",
                "numeric_code" => 218,
                "latitude" => -2,
                "longitude" => -77.5,
                "emoji_flag" => "🇪🇨"
            ],
            [
                "name" => "Egypt",
                "code" => "EG",
                "iso3" => "EGY",
                "numeric_code" => 818,
                "latitude" => 27,
                "longitude" => 30,
                "emoji_flag" => "🇪🇬"
            ],
            [
                "name" => "El Salvador",
                "code" => "SV",
                "iso3" => "SLV",
                "numeric_code" => 222,
                "latitude" => 13.8333,
                "longitude" => -88.9167,
                "emoji_flag" => "🇸🇻"
            ],
            [
                "name" => "Equatorial Guinea",
                "code" => "GQ",
                "iso3" => "GNQ",
                "numeric_code" => 226,
                "latitude" => 2,
                "longitude" => 10,
                "emoji_flag" => "🇬🇶"
            ],
            [
                "name" => "Eritrea",
                "code" => "ER",
                "iso3" => "ERI",
                "numeric_code" => 232,
                "latitude" => 15,
                "longitude" => 39,
                "emoji_flag" => "🇪🇷"
            ],
            [
                "name" => "Estonia",
                "code" => "EE",
                "iso3" => "EST",
                "numeric_code" => 233,
                "latitude" => 59,
                "longitude" => 26,
                "emoji_flag" => "🇪🇪"
            ],
            [
                "name" => "Ethiopia",
                "code" => "ET",
                "iso3" => "ETH",
                "numeric_code" => 231,
                "latitude" => 8,
                "longitude" => 38,
                "emoji_flag" => "🇪🇹"
            ],
            [
                "name" => "Falkland Islands (Malvinas)",
                "code" => "FK",
                "iso3" => "FLK",
                "numeric_code" => 238,
                "latitude" => -51.75,
                "longitude" => -59,
                "emoji_flag" => "🇫🇰"
            ],
            [
                "name" => "Faroe Islands",
                "code" => "FO",
                "iso3" => "FRO",
                "numeric_code" => 234,
                "latitude" => 62,
                "longitude" => -7,
                "emoji_flag" => "🇫🇴"
            ],
            [
                "name" => "Fiji",
                "code" => "FJ",
                "iso3" => "FJI",
                "numeric_code" => 242,
                "latitude" => -18,
                "longitude" => 175,
                "emoji_flag" => "🇫🇯"
            ],
            [
                "name" => "Finland",
                "code" => "FI",
                "iso3" => "FIN",
                "numeric_code" => 246,
                "latitude" => 64,
                "longitude" => 26,
                "emoji_flag" => "🇫🇮"
            ],
            [
                "name" => "France",
                "code" => "FR",
                "iso3" => "FRA",
                "numeric_code" => 250,
                "latitude" => 46,
                "longitude" => 2,
                "emoji_flag" => "🇫🇷"
            ],
            [
                "name" => "French Guiana",
                "code" => "GF",
                "iso3" => "GUF",
                "numeric_code" => 254,
                "latitude" => 4,
                "longitude" => -53,
                "emoji_flag" => "🇬🇫"
            ],
            [
                "name" => "French Polynesia",
                "code" => "PF",
                "iso3" => "PYF",
                "numeric_code" => 258,
                "latitude" => -15,
                "longitude" => -140,
                "emoji_flag" => "🇵🇫"
            ],
            [
                "name" => "French Southern Territories",
                "code" => "TF",
                "iso3" => "ATF",
                "numeric_code" => 260,
                "latitude" => -43,
                "longitude" => 67,
                "emoji_flag" => "🇹🇫"
            ],
            [
                "name" => "Gabon",
                "code" => "GA",
                "iso3" => "GAB",
                "numeric_code" => 266,
                "latitude" => -1,
                "longitude" => 11.75,
                "emoji_flag" => "🇬🇦"
            ],
            [
                "name" => "Gambia",
                "code" => "GM",
                "iso3" => "GMB",
                "numeric_code" => 270,
                "latitude" => 13.4667,
                "longitude" => -16.5667,
                "emoji_flag" => "🇬🇲"
            ],
            [
                "name" => "Georgia",
                "code" => "GE",
                "iso3" => "GEO",
                "numeric_code" => 268,
                "latitude" => 42,
                "longitude" => 43.5,
                "emoji_flag" => "🇬🇪"
            ],
            [
                "name" => "Germany",
                "code" => "DE",
                "iso3" => "DEU",
                "numeric_code" => 276,
                "latitude" => 51,
                "longitude" => 9,
                "emoji_flag" => "🇩🇪"
            ],
            [
                "name" => "Ghana",
                "code" => "GH",
                "iso3" => "GHA",
                "numeric_code" => 288,
                "latitude" => 8,
                "longitude" => -2,
                "emoji_flag" => "🇬🇭"
            ],
            [
                "name" => "Gibraltar",
                "code" => "GI",
                "iso3" => "GIB",
                "numeric_code" => 292,
                "latitude" => 36.1833,
                "longitude" => -5.3667,
                "emoji_flag" => "🇬🇮"
            ],
            [
                "name" => "Greece",
                "code" => "GR",
                "iso3" => "GRC",
                "numeric_code" => 300,
                "latitude" => 39,
                "longitude" => 22,
                "emoji_flag" => "🇬🇷"
            ],
            [
                "name" => "Greenland",
                "code" => "GL",
                "iso3" => "GRL",
                "numeric_code" => 304,
                "latitude" => 72,
                "longitude" => -40,
                "emoji_flag" => "🇬🇱"
            ],
            [
                "name" => "Grenada",
                "code" => "GD",
                "iso3" => "GRD",
                "numeric_code" => 308,
                "latitude" => 12.1167,
                "longitude" => -61.6667,
                "emoji_flag" => "🇬🇩"
            ],
            [
                "name" => "Guadeloupe",
                "code" => "GP",
                "iso3" => "GLP",
                "numeric_code" => 312,
                "latitude" => 16.25,
                "longitude" => -61.5833,
                "emoji_flag" => "🇬🇵"
            ],
            [
                "name" => "Guam",
                "code" => "GU",
                "iso3" => "GUM",
                "numeric_code" => 316,
                "latitude" => 13.4667,
                "longitude" => 144.7833,
                "emoji_flag" => "🇬🇺"
            ],
            [
                "name" => "Guatemala",
                "code" => "GT",
                "iso3" => "GTM",
                "numeric_code" => 320,
                "latitude" => 15.5,
                "longitude" => -90.25,
                "emoji_flag" => "🇬🇹"
            ],
            [
                "name" => "Guernsey",
                "code" => "GG",
                "iso3" => "GGY",
                "numeric_code" => 831,
                "latitude" => 49.5,
                "longitude" => -2.56,
                "emoji_flag" => "🇬🇬"
            ],
            [
                "name" => "Guinea",
                "code" => "GN",
                "iso3" => "GIN",
                "numeric_code" => 324,
                "latitude" => 11,
                "longitude" => -10,
                "emoji_flag" => "🇬🇳"
            ],
            [
                "name" => "Guinea-Bissau",
                "code" => "GW",
                "iso3" => "GNB",
                "numeric_code" => 624,
                "latitude" => 12,
                "longitude" => -15,
                "emoji_flag" => "🇬🇼"
            ],
            [
                "name" => "Guyana",
                "code" => "GY",
                "iso3" => "GUY",
                "numeric_code" => 328,
                "latitude" => 5,
                "longitude" => -59,
                "emoji_flag" => "🇬🇾"
            ],
            [
                "name" => "Haiti",
                "code" => "HT",
                "iso3" => "HTI",
                "numeric_code" => 332,
                "latitude" => 19,
                "longitude" => -72.4167,
                "emoji_flag" => "🇭🇹"
            ],
            [
                "name" => "Heard Island and McDonald Islands",
                "code" => "HM",
                "iso3" => "HMD",
                "numeric_code" => 334,
                "latitude" => -53.1,
                "longitude" => 72.5167,
                "emoji_flag" => "🇭🇲"
            ],
            [
                "name" => "Holy See (Vatican City State)",
                "code" => "VA",
                "iso3" => "VAT",
                "numeric_code" => 336,
                "latitude" => 41.9,
                "longitude" => 12.45,
                "emoji_flag" => "🇻🇦"
            ],
            [
                "name" => "Honduras",
                "code" => "HN",
                "iso3" => "HND",
                "numeric_code" => 340,
                "latitude" => 15,
                "longitude" => -86.5,
                "emoji_flag" => "🇭🇳"
            ],
            [
                "name" => "Hong Kong",
                "code" => "HK",
                "iso3" => "HKG",
                "numeric_code" => 344,
                "latitude" => 22.25,
                "longitude" => 114.1667,
                "emoji_flag" => "🇭🇰"
            ],
            [
                "name" => "Hungary",
                "code" => "HU",
                "iso3" => "HUN",
                "numeric_code" => 348,
                "latitude" => 47,
                "longitude" => 20,
                "emoji_flag" => "🇭🇺"
            ],
            [
                "name" => "Iceland",
                "code" => "IS",
                "iso3" => "ISL",
                "numeric_code" => 352,
                "latitude" => 65,
                "longitude" => -18,
                "emoji_flag" => "🇮🇸"
            ],
            [
                "name" => "India",
                "code" => "IN",
                "iso3" => "IND",
                "numeric_code" => 356,
                "latitude" => 20,
                "longitude" => 77,
                "emoji_flag" => "🇮🇳"
            ],
            [
                "name" => "Indonesia",
                "code" => "ID",
                "iso3" => "IDN",
                "numeric_code" => 360,
                "latitude" => -5,
                "longitude" => 120,
                "emoji_flag" => "🇮🇩"
            ],
            [
                "name" => "Iran, Islamic Republic of",
                "code" => "IR",
                "iso3" => "IRN",
                "numeric_code" => 364,
                "latitude" => 32,
                "longitude" => 53,
                "emoji_flag" => "🇮🇷"
            ],
            [
                "name" => "Iraq",
                "code" => "IQ",
                "iso3" => "IRQ",
                "numeric_code" => 368,
                "latitude" => 33,
                "longitude" => 44,
                "emoji_flag" => "🇮🇶"
            ],
            [
                "name" => "Ireland",
                "code" => "IE",
                "iso3" => "IRL",
                "numeric_code" => 372,
                "latitude" => 53,
                "longitude" => -8,
                "emoji_flag" => "🇮🇪"
            ],
            [
                "name" => "Isle of Man",
                "code" => "IM",
                "iso3" => "IMN",
                "numeric_code" => 833,
                "latitude" => 54.23,
                "longitude" => -4.55,
                "emoji_flag" => "🇮🇲"
            ],
            [
                "name" => "Israel",
                "code" => "IL",
                "iso3" => "ISR",
                "numeric_code" => 376,
                "latitude" => 31.5,
                "longitude" => 34.75,
                "emoji_flag" => "🇮🇱"
            ],
            [
                "name" => "Italy",
                "code" => "IT",
                "iso3" => "ITA",
                "numeric_code" => 380,
                "latitude" => 42.8333,
                "longitude" => 12.8333,
                "emoji_flag" => "🇮🇹"
            ],
            [
                "name" => "Jamaica",
                "code" => "JM",
                "iso3" => "JAM",
                "numeric_code" => 388,
                "latitude" => 18.25,
                "longitude" => -77.5,
                "emoji_flag" => "🇯🇲"
            ],
            [
                "name" => "Japan",
                "code" => "JP",
                "iso3" => "JPN",
                "numeric_code" => 392,
                "latitude" => 36,
                "longitude" => 138,
                "emoji_flag" => "🇯🇵"
            ],
            [
                "name" => "Jersey",
                "code" => "JE",
                "iso3" => "JEY",
                "numeric_code" => 832,
                "latitude" => 49.21,
                "longitude" => -2.13,
                "emoji_flag" => "🇯🇪"
            ],
            [
                "name" => "Jordan",
                "code" => "JO",
                "iso3" => "JOR",
                "numeric_code" => 400,
                "latitude" => 31,
                "longitude" => 36,
                "emoji_flag" => "🇯🇴"
            ],
            [
                "name" => "Kazakhstan",
                "code" => "KZ",
                "iso3" => "KAZ",
                "numeric_code" => 398,
                "latitude" => 48,
                "longitude" => 68,
                "emoji_flag" => "🇰🇿"
            ],
            [
                "name" => "Kenya",
                "code" => "KE",
                "iso3" => "KEN",
                "numeric_code" => 404,
                "latitude" => 1,
                "longitude" => 38,
                "emoji_flag" => "🇰🇪"
            ],
            [
                "name" => "Kiribati",
                "code" => "KI",
                "iso3" => "KIR",
                "numeric_code" => 296,
                "latitude" => 1.4167,
                "longitude" => 173,
                "emoji_flag" => "🇰🇮"
            ],
            [
                "name" => "Korea, Democratic People's Republic of",
                "code" => "KP",
                "iso3" => "PRK",
                "numeric_code" => 408,
                "latitude" => 40,
                "longitude" => 127,
                "emoji_flag" => "🇰🇵"
            ],
            [
                "name" => "South Korea",
                "code" => "KR",
                "iso3" => "KOR",
                "numeric_code" => 410,
                "latitude" => 37,
                "longitude" => 127.5,
                "emoji_flag" => "🇰🇷"
            ],
            [
                "name" => "Kuwait",
                "code" => "KW",
                "iso3" => "KWT",
                "numeric_code" => 414,
                "latitude" => 29.3375,
                "longitude" => 47.6581,
                "emoji_flag" => "🇰🇼"
            ],
            [
                "name" => "Kyrgyzstan",
                "code" => "KG",
                "iso3" => "KGZ",
                "numeric_code" => 417,
                "latitude" => 41,
                "longitude" => 75,
                "emoji_flag" => "🇰🇬"
            ],
            [
                "name" => "Lao People's Democratic Republic",
                "code" => "LA",
                "iso3" => "LAO",
                "numeric_code" => 418,
                "latitude" => 18,
                "longitude" => 105,
                "emoji_flag" => "🇱🇦"
            ],
            [
                "name" => "Latvia",
                "code" => "LV",
                "iso3" => "LVA",
                "numeric_code" => 428,
                "latitude" => 57,
                "longitude" => 25,
                "emoji_flag" => "🇱🇻"
            ],
            [
                "name" => "Lebanon",
                "code" => "LB",
                "iso3" => "LBN",
                "numeric_code" => 422,
                "latitude" => 33.8333,
                "longitude" => 35.8333,
                "emoji_flag" => "🇱🇧"
            ],
            [
                "name" => "Lesotho",
                "code" => "LS",
                "iso3" => "LSO",
                "numeric_code" => 426,
                "latitude" => -29.5,
                "longitude" => 28.5,
                "emoji_flag" => "🇱🇸"
            ],
            [
                "name" => "Liberia",
                "code" => "LR",
                "iso3" => "LBR",
                "numeric_code" => 430,
                "latitude" => 6.5,
                "longitude" => -9.5,
                "emoji_flag" => "🇱🇷"
            ],
            [
                "name" => "Libya",
                "code" => "LY",
                "iso3" => "LBY",
                "numeric_code" => 434,
                "latitude" => 25,
                "longitude" => 17,
                "emoji_flag" => "🇱🇾"
            ],
            [
                "name" => "Liechtenstein",
                "code" => "LI",
                "iso3" => "LIE",
                "numeric_code" => 438,
                "latitude" => 47.1667,
                "longitude" => 9.5333,
                "emoji_flag" => "🇱🇮"
            ],
            [
                "name" => "Lithuania",
                "code" => "LT",
                "iso3" => "LTU",
                "numeric_code" => 440,
                "latitude" => 56,
                "longitude" => 24,
                "emoji_flag" => "🇱🇹"
            ],
            [
                "name" => "Luxembourg",
                "code" => "LU",
                "iso3" => "LUX",
                "numeric_code" => 442,
                "latitude" => 49.75,
                "longitude" => 6.1667,
                "emoji_flag" => "🇱🇺"
            ],
            [
                "name" => "Macao",
                "code" => "MO",
                "iso3" => "MAC",
                "numeric_code" => 446,
                "latitude" => 22.1667,
                "longitude" => 113.55,
                "emoji_flag" => "🇲🇴"
            ],
            [
                "name" => "Macedonia, the former Yugoslav Republic of",
                "code" => "MK",
                "iso3" => "MKD",
                "numeric_code" => 807,
                "latitude" => 41.8333,
                "longitude" => 22,
                "emoji_flag" => "🇲🇰"
            ],
            [
                "name" => "Madagascar",
                "code" => "MG",
                "iso3" => "MDG",
                "numeric_code" => 450,
                "latitude" => -20,
                "longitude" => 47,
                "emoji_flag" => "🇲🇬"
            ],
            [
                "name" => "Malawi",
                "code" => "MW",
                "iso3" => "MWI",
                "numeric_code" => 454,
                "latitude" => -13.5,
                "longitude" => 34,
                "emoji_flag" => "🇲🇼"
            ],
            [
                "name" => "Malaysia",
                "code" => "MY",
                "iso3" => "MYS",
                "numeric_code" => 458,
                "latitude" => 2.5,
                "longitude" => 112.5,
                "emoji_flag" => "🇲🇾"
            ],
            [
                "name" => "Maldives",
                "code" => "MV",
                "iso3" => "MDV",
                "numeric_code" => 462,
                "latitude" => 3.25,
                "longitude" => 73,
                "emoji_flag" => "🇲🇻"
            ],
            [
                "name" => "Mali",
                "code" => "ML",
                "iso3" => "MLI",
                "numeric_code" => 466,
                "latitude" => 17,
                "longitude" => -4,
                "emoji_flag" => "🇲🇱"
            ],
            [
                "name" => "Malta",
                "code" => "MT",
                "iso3" => "MLT",
                "numeric_code" => 470,
                "latitude" => 35.8333,
                "longitude" => 14.5833,
                "emoji_flag" => "🇲🇹"
            ],
            [
                "name" => "Marshall Islands",
                "code" => "MH",
                "iso3" => "MHL",
                "numeric_code" => 584,
                "latitude" => 9,
                "longitude" => 168,
                "emoji_flag" => "🇲🇭"
            ],
            [
                "name" => "Martinique",
                "code" => "MQ",
                "iso3" => "MTQ",
                "numeric_code" => 474,
                "latitude" => 14.6667,
                "longitude" => -61,
                "emoji_flag" => "🇲🇶"
            ],
            [
                "name" => "Mauritania",
                "code" => "MR",
                "iso3" => "MRT",
                "numeric_code" => 478,
                "latitude" => 20,
                "longitude" => -12,
                "emoji_flag" => "🇲🇷"
            ],
            [
                "name" => "Mauritius",
                "code" => "MU",
                "iso3" => "MUS",
                "numeric_code" => 480,
                "latitude" => -20.2833,
                "longitude" => 57.55,
                "emoji_flag" => "🇲🇺"
            ],
            [
                "name" => "Mayotte",
                "code" => "YT",
                "iso3" => "MYT",
                "numeric_code" => 175,
                "latitude" => -12.8333,
                "longitude" => 45.1667,
                "emoji_flag" => "🇾🇹"
            ],
            [
                "name" => "Mexico",
                "code" => "MX",
                "iso3" => "MEX",
                "numeric_code" => 484,
                "latitude" => 23,
                "longitude" => -102,
                "emoji_flag" => "🇲🇽"
            ],
            [
                "name" => "Micronesia, Federated States of",
                "code" => "FM",
                "iso3" => "FSM",
                "numeric_code" => 583,
                "latitude" => 6.9167,
                "longitude" => 158.25,
                "emoji_flag" => "🇫🇲"
            ],
            [
                "name" => "Moldova, Republic of",
                "code" => "MD",
                "iso3" => "MDA",
                "numeric_code" => 498,
                "latitude" => 47,
                "longitude" => 29,
                "emoji_flag" => "🇲🇩"
            ],
            [
                "name" => "Monaco",
                "code" => "MC",
                "iso3" => "MCO",
                "numeric_code" => 492,
                "latitude" => 43.7333,
                "longitude" => 7.4,
                "emoji_flag" => "🇲🇨"
            ],
            [
                "name" => "Mongolia",
                "code" => "MN",
                "iso3" => "MNG",
                "numeric_code" => 496,
                "latitude" => 46,
                "longitude" => 105,
                "emoji_flag" => "🇲🇳"
            ],
            [
                "name" => "Montenegro",
                "code" => "ME",
                "iso3" => "MNE",
                "numeric_code" => 499,
                "latitude" => 42,
                "longitude" => 19,
                "emoji_flag" => "🇲🇪"
            ],
            [
                "name" => "Montserrat",
                "code" => "MS",
                "iso3" => "MSR",
                "numeric_code" => 500,
                "latitude" => 16.75,
                "longitude" => -62.2,
                "emoji_flag" => "🇲🇸"
            ],
            [
                "name" => "Morocco",
                "code" => "MA",
                "iso3" => "MAR",
                "numeric_code" => 504,
                "latitude" => 32,
                "longitude" => -5,
                "emoji_flag" => "🇲🇦"
            ],
            [
                "name" => "Mozambique",
                "code" => "MZ",
                "iso3" => "MOZ",
                "numeric_code" => 508,
                "latitude" => -18.25,
                "longitude" => 35,
                "emoji_flag" => "🇲🇿"
            ],
            [
                "name" => "Myanmar",
                "code" => "MM",
                "iso3" => "MMR",
                "numeric_code" => 104,
                "latitude" => 22,
                "longitude" => 98,
                "emoji_flag" => "🇲🇲"
            ],
            [
                "name" => "Namibia",
                "code" => "NA",
                "iso3" => "NAM",
                "numeric_code" => 516,
                "latitude" => -22,
                "longitude" => 17,
                "emoji_flag" => "🇳🇦"
            ],
            [
                "name" => "Nauru",
                "code" => "NR",
                "iso3" => "NRU",
                "numeric_code" => 520,
                "latitude" => -0.5333,
                "longitude" => 166.9167,
                "emoji_flag" => "🇳🇷"
            ],
            [
                "name" => "Nepal",
                "code" => "NP",
                "iso3" => "NPL",
                "numeric_code" => 524,
                "latitude" => 28,
                "longitude" => 84,
                "emoji_flag" => "🇳🇵"
            ],
            [
                "name" => "Netherlands",
                "code" => "NL",
                "iso3" => "NLD",
                "numeric_code" => 528,
                "latitude" => 52.5,
                "longitude" => 5.75,
                "emoji_flag" => "🇳🇱"
            ],
            [
                "name" => "Netherlands Antilles",
                "code" => "AN",
                "iso3" => "ANT",
                "numeric_code" => 530,
                "latitude" => 12.25,
                "longitude" => -68.75,
                "emoji_flag" => "🇦🇳"
            ],
            [
                "name" => "New Caledonia",
                "code" => "NC",
                "iso3" => "NCL",
                "numeric_code" => 540,
                "latitude" => -21.5,
                "longitude" => 165.5,
                "emoji_flag" => "🇳🇨"
            ],
            [
                "name" => "New Zealand",
                "code" => "NZ",
                "iso3" => "NZL",
                "numeric_code" => 554,
                "latitude" => -41,
                "longitude" => 174,
                "emoji_flag" => "🇳🇿"
            ],
            [
                "name" => "Nicaragua",
                "code" => "NI",
                "iso3" => "NIC",
                "numeric_code" => 558,
                "latitude" => 13,
                "longitude" => -85,
                "emoji_flag" => "🇳🇮"
            ],
            [
                "name" => "Niger",
                "code" => "NE",
                "iso3" => "NER",
                "numeric_code" => 562,
                "latitude" => 16,
                "longitude" => 8,
                "emoji_flag" => "🇳🇪"
            ],
            [
                "name" => "Nigeria",
                "code" => "NG",
                "iso3" => "NGA",
                "numeric_code" => 566,
                "latitude" => 10,
                "longitude" => 8,
                "emoji_flag" => "🇳🇬"
            ],
            [
                "name" => "Niue",
                "code" => "NU",
                "iso3" => "NIU",
                "numeric_code" => 570,
                "latitude" => -19.0333,
                "longitude" => -169.8667,
                "emoji_flag" => "🇳🇺"
            ],
            [
                "name" => "Norfolk Island",
                "code" => "NF",
                "iso3" => "NFK",
                "numeric_code" => 574,
                "latitude" => -29.0333,
                "longitude" => 167.95,
                "emoji_flag" => "🇳🇫"
            ],
            [
                "name" => "Northern Mariana Islands",
                "code" => "MP",
                "iso3" => "MNP",
                "numeric_code" => 580,
                "latitude" => 15.2,
                "longitude" => 145.75,
                "emoji_flag" => "🇲🇵"
            ],
            [
                "name" => "Norway",
                "code" => "NO",
                "iso3" => "NOR",
                "numeric_code" => 578,
                "latitude" => 62,
                "longitude" => 10,
                "emoji_flag" => "🇳🇴"
            ],
            [
                "name" => "Oman",
                "code" => "OM",
                "iso3" => "OMN",
                "numeric_code" => 512,
                "latitude" => 21,
                "longitude" => 57,
                "emoji_flag" => "🇴🇲"
            ],
            [
                "name" => "Pakistan",
                "code" => "PK",
                "iso3" => "PAK",
                "numeric_code" => 586,
                "latitude" => 30,
                "longitude" => 70,
                "emoji_flag" => "🇵🇰"
            ],
            [
                "name" => "Palau",
                "code" => "PW",
                "iso3" => "PLW",
                "numeric_code" => 585,
                "latitude" => 7.5,
                "longitude" => 134.5,
                "emoji_flag" => "🇵🇼"
            ],
            [
                "name" => "Palestinian Territory, Occupied",
                "code" => "PS",
                "iso3" => "PSE",
                "numeric_code" => 275,
                "latitude" => 32,
                "longitude" => 35.25,
                "emoji_flag" => "🇵🇸"
            ],
            [
                "name" => "Panama",
                "code" => "PA",
                "iso3" => "PAN",
                "numeric_code" => 591,
                "latitude" => 9,
                "longitude" => -80,
                "emoji_flag" => "🇵🇦"
            ],
            [
                "name" => "Papua New Guinea",
                "code" => "PG",
                "iso3" => "PNG",
                "numeric_code" => 598,
                "latitude" => -6,
                "longitude" => 147,
                "emoji_flag" => "🇵🇬"
            ],
            [
                "name" => "Paraguay",
                "code" => "PY",
                "iso3" => "PRY",
                "numeric_code" => 600,
                "latitude" => -23,
                "longitude" => -58,
                "emoji_flag" => "🇵🇾"
            ],
            [
                "name" => "Peru",
                "code" => "PE",
                "iso3" => "PER",
                "numeric_code" => 604,
                "latitude" => -10,
                "longitude" => -76,
                "emoji_flag" => "🇵🇪"
            ],
            [
                "name" => "Philippines",
                "code" => "PH",
                "iso3" => "PHL",
                "numeric_code" => 608,
                "latitude" => 13,
                "longitude" => 122,
                "emoji_flag" => "🇵🇭"
            ],
            [
                "name" => "Pitcairn",
                "code" => "PN",
                "iso3" => "PCN",
                "numeric_code" => 612,
                "latitude" => -24.7,
                "longitude" => -127.4,
                "emoji_flag" => "🇵🇳"
            ],
            [
                "name" => "Poland",
                "code" => "PL",
                "iso3" => "POL",
                "numeric_code" => 616,
                "latitude" => 52,
                "longitude" => 20,
                "emoji_flag" => "🇵🇱"
            ],
            [
                "name" => "Portugal",
                "code" => "PT",
                "iso3" => "PRT",
                "numeric_code" => 620,
                "latitude" => 39.5,
                "longitude" => -8,
                "emoji_flag" => "🇵🇹"
            ],
            [
                "name" => "Puerto Rico",
                "code" => "PR",
                "iso3" => "PRI",
                "numeric_code" => 630,
                "latitude" => 18.25,
                "longitude" => -66.5,
                "emoji_flag" => "🇵🇷"
            ],
            [
                "name" => "Qatar",
                "code" => "QA",
                "iso3" => "QAT",
                "numeric_code" => 634,
                "latitude" => 25.5,
                "longitude" => 51.25,
                "emoji_flag" => "🇶🇦"
            ],
            [
                "name" => "Réunion",
                "code" => "RE",
                "iso3" => "REU",
                "numeric_code" => 638,
                "latitude" => -21.1,
                "longitude" => 55.6,
                "emoji_flag" => "🇷🇪"
            ],
            [
                "name" => "Romania",
                "code" => "RO",
                "iso3" => "ROU",
                "numeric_code" => 642,
                "latitude" => 46,
                "longitude" => 25,
                "emoji_flag" => "🇷🇴"
            ],
            [
                "name" => "Russia",
                "code" => "RU",
                "iso3" => "RUS",
                "numeric_code" => 643,
                "latitude" => 60,
                "longitude" => 100,
                "emoji_flag" => "🇷🇺"
            ],
            [
                "name" => "Rwanda",
                "code" => "RW",
                "iso3" => "RWA",
                "numeric_code" => 646,
                "latitude" => -2,
                "longitude" => 30,
                "emoji_flag" => "🇷🇼"
            ],
            [
                "name" => "Saint Helena, Ascension and Tristan da Cunha",
                "code" => "SH",
                "iso3" => "SHN",
                "numeric_code" => 654,
                "latitude" => -15.9333,
                "longitude" => -5.7,
                "emoji_flag" => "🇸🇭"
            ],
            [
                "name" => "Saint Kitts and Nevis",
                "code" => "KN",
                "iso3" => "KNA",
                "numeric_code" => 659,
                "latitude" => 17.3333,
                "longitude" => -62.75,
                "emoji_flag" => "🇰🇳"
            ],
            [
                "name" => "Saint Lucia",
                "code" => "LC",
                "iso3" => "LCA",
                "numeric_code" => 662,
                "latitude" => 13.8833,
                "longitude" => -61.1333,
                "emoji_flag" => "🇱🇨"
            ],
            [
                "name" => "Saint Pierre and Miquelon",
                "code" => "PM",
                "iso3" => "SPM",
                "numeric_code" => 666,
                "latitude" => 46.8333,
                "longitude" => -56.3333,
                "emoji_flag" => "🇵🇲"
            ],
            [
                "name" => "Saint Vincent and the Grenadines",
                "code" => "VC",
                "iso3" => "VCT",
                "numeric_code" => 670,
                "latitude" => 13.25,
                "longitude" => -61.2,
                "emoji_flag" => "🇻🇨"
            ],
            [
                "name" => "Samoa",
                "code" => "WS",
                "iso3" => "WSM",
                "numeric_code" => 882,
                "latitude" => -13.5833,
                "longitude" => -172.3333,
                "emoji_flag" => "🇼🇸"
            ],
            [
                "name" => "San Marino",
                "code" => "SM",
                "iso3" => "SMR",
                "numeric_code" => 674,
                "latitude" => 43.7667,
                "longitude" => 12.4167,
                "emoji_flag" => "🇸🇲"
            ],
            [
                "name" => "Sao Tome and Principe",
                "code" => "ST",
                "iso3" => "STP",
                "numeric_code" => 678,
                "latitude" => 1,
                "longitude" => 7,
                "emoji_flag" => "🇸🇹"
            ],
            [
                "name" => "Saudi Arabia",
                "code" => "SA",
                "iso3" => "SAU",
                "numeric_code" => 682,
                "latitude" => 25,
                "longitude" => 45,
                "emoji_flag" => "🇸🇦"
            ],
            [
                "name" => "Senegal",
                "code" => "SN",
                "iso3" => "SEN",
                "numeric_code" => 686,
                "latitude" => 14,
                "longitude" => -14,
                "emoji_flag" => "🇸🇳"
            ],
            [
                "name" => "Serbia",
                "code" => "RS",
                "iso3" => "SRB",
                "numeric_code" => 688,
                "latitude" => 44,
                "longitude" => 21,
                "emoji_flag" => "🇷🇸"
            ],
            [
                "name" => "Seychelles",
                "code" => "SC",
                "iso3" => "SYC",
                "numeric_code" => 690,
                "latitude" => -4.5833,
                "longitude" => 55.6667,
                "emoji_flag" => "🇸🇨"
            ],
            [
                "name" => "Sierra Leone",
                "code" => "SL",
                "iso3" => "SLE",
                "numeric_code" => 694,
                "latitude" => 8.5,
                "longitude" => -11.5,
                "emoji_flag" => "🇸🇱"
            ],
            [
                "name" => "Singapore",
                "code" => "SG",
                "iso3" => "SGP",
                "numeric_code" => 702,
                "latitude" => 1.3667,
                "longitude" => 103.8,
                "emoji_flag" => "🇸🇬"
            ],
            [
                "name" => "Slovakia",
                "code" => "SK",
                "iso3" => "SVK",
                "numeric_code" => 703,
                "latitude" => 48.6667,
                "longitude" => 19.5,
                "emoji_flag" => "🇸🇰"
            ],
            [
                "name" => "Slovenia",
                "code" => "SI",
                "iso3" => "SVN",
                "numeric_code" => 705,
                "latitude" => 46,
                "longitude" => 15,
                "emoji_flag" => "🇸🇮"
            ],
            [
                "name" => "Solomon Islands",
                "code" => "SB",
                "iso3" => "SLB",
                "numeric_code" => 90,
                "latitude" => -8,
                "longitude" => 159,
                "emoji_flag" => "🇸🇧"
            ],
            [
                "name" => "Somalia",
                "code" => "SO",
                "iso3" => "SOM",
                "numeric_code" => 706,
                "latitude" => 10,
                "longitude" => 49,
                "emoji_flag" => "🇸🇴"
            ],
            [
                "name" => "South Africa",
                "code" => "ZA",
                "iso3" => "ZAF",
                "numeric_code" => 710,
                "latitude" => -29,
                "longitude" => 24,
                "emoji_flag" => "🇿🇦"
            ],
            [
                "name" => "South Georgia and the South Sandwich Islands",
                "code" => "GS",
                "iso3" => "SGS",
                "numeric_code" => 239,
                "latitude" => -54.5,
                "longitude" => -37,
                "emoji_flag" => "🇬🇸"
            ],
            [
                "name" => "South Sudan",
                "code" => "SS",
                "iso3" => "SSD",
                "numeric_code" => 728,
                "latitude" => 8,
                "longitude" => 30,
                "emoji_flag" => "🇸🇸"
            ],
            [
                "name" => "Spain",
                "code" => "ES",
                "iso3" => "ESP",
                "numeric_code" => 724,
                "latitude" => 40,
                "longitude" => -4,
                "emoji_flag" => "🇪🇸"
            ],
            [
                "name" => "Sri Lanka",
                "code" => "LK",
                "iso3" => "LKA",
                "numeric_code" => 144,
                "latitude" => 7,
                "longitude" => 81,
                "emoji_flag" => "🇱🇰"
            ],
            [
                "name" => "Sudan",
                "code" => "SD",
                "iso3" => "SDN",
                "numeric_code" => 736,
                "latitude" => 15,
                "longitude" => 30,
                "emoji_flag" => "🇸🇩"
            ],
            [
                "name" => "Suriname",
                "code" => "SR",
                "iso3" => "SUR",
                "numeric_code" => 740,
                "latitude" => 4,
                "longitude" => -56,
                "emoji_flag" => "🇸🇷"
            ],
            [
                "name" => "Svalbard and Jan Mayen",
                "code" => "SJ",
                "iso3" => "SJM",
                "numeric_code" => 744,
                "latitude" => 78,
                "longitude" => 20,
                "emoji_flag" => "🇸🇯"
            ],
            [
                "name" => "Swaziland",
                "code" => "SZ",
                "iso3" => "SWZ",
                "numeric_code" => 748,
                "latitude" => -26.5,
                "longitude" => 31.5,
                "emoji_flag" => "🇸🇿"
            ],
            [
                "name" => "Sweden",
                "code" => "SE",
                "iso3" => "SWE",
                "numeric_code" => 752,
                "latitude" => 62,
                "longitude" => 15,
                "emoji_flag" => "🇸🇪"
            ],
            [
                "name" => "Switzerland",
                "code" => "CH",
                "iso3" => "CHE",
                "numeric_code" => 756,
                "latitude" => 47,
                "longitude" => 8,
                "emoji_flag" => "🇨🇭"
            ],
            [
                "name" => "Syrian Arab Republic",
                "code" => "SY",
                "iso3" => "SYR",
                "numeric_code" => 760,
                "latitude" => 35,
                "longitude" => 38,
                "emoji_flag" => "🇸🇾"
            ],
            [
                "name" => "Taiwan",
                "code" => "TW",
                "iso3" => "TWN",
                "numeric_code" => 158,
                "latitude" => 23.5,
                "longitude" => 121,
                "emoji_flag" => "🇹🇼"
            ],
            [
                "name" => "Tajikistan",
                "code" => "TJ",
                "iso3" => "TJK",
                "numeric_code" => 762,
                "latitude" => 39,
                "longitude" => 71,
                "emoji_flag" => "🇹🇯"
            ],
            [
                "name" => "Tanzania, United Republic of",
                "code" => "TZ",
                "iso3" => "TZA",
                "numeric_code" => 834,
                "latitude" => -6,
                "longitude" => 35,
                "emoji_flag" => "🇹🇿"
            ],
            [
                "name" => "Thailand",
                "code" => "TH",
                "iso3" => "THA",
                "numeric_code" => 764,
                "latitude" => 15,
                "longitude" => 100,
                "emoji_flag" => "🇹🇭"
            ],
            [
                "name" => "Timor-Leste",
                "code" => "TL",
                "iso3" => "TLS",
                "numeric_code" => 626,
                "latitude" => -8.55,
                "longitude" => 125.5167,
                "emoji_flag" => "🇹🇱"
            ],
            [
                "name" => "Togo",
                "code" => "TG",
                "iso3" => "TGO",
                "numeric_code" => 768,
                "latitude" => 8,
                "longitude" => 1.1667,
                "emoji_flag" => "🇹🇬"
            ],
            [
                "name" => "Tokelau",
                "code" => "TK",
                "iso3" => "TKL",
                "numeric_code" => 772,
                "latitude" => -9,
                "longitude" => -172,
                "emoji_flag" => "🇹🇰"
            ],
            [
                "name" => "Tonga",
                "code" => "TO",
                "iso3" => "TON",
                "numeric_code" => 776,
                "latitude" => -20,
                "longitude" => -175,
                "emoji_flag" => "🇹🇴"
            ],
            [
                "name" => "Trinidad and Tobago",
                "code" => "TT",
                "iso3" => "TTO",
                "numeric_code" => 780,
                "latitude" => 11,
                "longitude" => -61,
                "emoji_flag" => "🇹🇹"
            ],
            [
                "name" => "Tunisia",
                "code" => "TN",
                "iso3" => "TUN",
                "numeric_code" => 788,
                "latitude" => 34,
                "longitude" => 9,
                "emoji_flag" => "🇹🇳"
            ],
            [
                "name" => "Turkey",
                "code" => "TR",
                "iso3" => "TUR",
                "numeric_code" => 792,
                "latitude" => 39,
                "longitude" => 35,
                "emoji_flag" => "🇹🇷"
            ],
            [
                "name" => "Turkmenistan",
                "code" => "TM",
                "iso3" => "TKM",
                "numeric_code" => 795,
                "latitude" => 40,
                "longitude" => 60,
                "emoji_flag" => "🇹🇲"
            ],
            [
                "name" => "Turks and Caicos Islands",
                "code" => "TC",
                "iso3" => "TCA",
                "numeric_code" => 796,
                "latitude" => 21.75,
                "longitude" => -71.5833,
                "emoji_flag" => "🇹🇨"
            ],
            [
                "name" => "Tuvalu",
                "code" => "TV",
                "iso3" => "TUV",
                "numeric_code" => 798,
                "latitude" => -8,
                "longitude" => 178,
                "emoji_flag" => "🇹🇻"
            ],
            [
                "name" => "Uganda",
                "code" => "UG",
                "iso3" => "UGA",
                "numeric_code" => 800,
                "latitude" => 1,
                "longitude" => 32,
                "emoji_flag" => "🇺🇬"
            ],
            [
                "name" => "Ukraine",
                "code" => "UA",
                "iso3" => "UKR",
                "numeric_code" => 804,
                "latitude" => 49,
                "longitude" => 32,
                "emoji_flag" => "🇺🇦"
            ],
            [
                "name" => "United Arab Emirates",
                "code" => "AE",
                "iso3" => "ARE",
                "numeric_code" => 784,
                "latitude" => 24,
                "longitude" => 54,
                "emoji_flag" => "🇦🇪"
            ],
            [
                "name" => "United Kingdom",
                "code" => "GB",
                "iso3" => "GBR",
                "numeric_code" => 826,
                "latitude" => 54,
                "longitude" => -2,
                "emoji_flag" => "🇬🇧"
            ],
            [
                "name" => "United States",
                "code" => "US",
                "iso3" => "USA",
                "numeric_code" => 840,
                "latitude" => 38,
                "longitude" => -97,
                "emoji_flag" => "🇺🇸"
            ],
            [
                "name" => "United States Minor Outlying Islands",
                "code" => "UM",
                "iso3" => "UMI",
                "numeric_code" => 581,
                "latitude" => 19.2833,
                "longitude" => 166.6,
                "emoji_flag" => "🇺🇲"
            ],
            [
                "name" => "Uruguay",
                "code" => "UY",
                "iso3" => "URY",
                "numeric_code" => 858,
                "latitude" => -33,
                "longitude" => -56,
                "emoji_flag" => "🇺🇾"
            ],
            [
                "name" => "Uzbekistan",
                "code" => "UZ",
                "iso3" => "UZB",
                "numeric_code" => 860,
                "latitude" => 41,
                "longitude" => 64,
                "emoji_flag" => "🇺🇿"
            ],
            [
                "name" => "Vanuatu",
                "code" => "VU",
                "iso3" => "VUT",
                "numeric_code" => 548,
                "latitude" => -16,
                "longitude" => 167,
                "emoji_flag" => "🇻🇺"
            ],
            [
                "name" => "Venezuela",
                "code" => "VE",
                "iso3" => "VEN",
                "numeric_code" => 862,
                "latitude" => 8,
                "longitude" => -66,
                "emoji_flag" => "🇻🇪"
            ],
            [
                "name" => "Vietnam",
                "code" => "VN",
                "iso3" => "VNM",
                "numeric_code" => 704,
                "latitude" => 16,
                "longitude" => 106,
                "emoji_flag" => "🇻🇳"
            ],
            [
                "name" => "Virgin Islands, British",
                "code" => "VG",
                "iso3" => "VGB",
                "numeric_code" => 92,
                "latitude" => 18.5,
                "longitude" => -64.5,
                "emoji_flag" => "🇻🇬"
            ],
            [
                "name" => "Virgin Islands, U.S.",
                "code" => "VI",
                "iso3" => "VIR",
                "numeric_code" => 850,
                "latitude" => 18.3333,
                "longitude" => -64.8333,
                "emoji_flag" => "🇻🇮"
            ],
            [
                "name" => "Wallis and Futuna",
                "code" => "WF",
                "iso3" => "WLF",
                "numeric_code" => 876,
                "latitude" => -13.3,
                "longitude" => -176.2,
                "emoji_flag" => "🇼🇫"
            ],
            [
                "name" => "Western Sahara",
                "code" => "EH",
                "iso3" => "ESH",
                "numeric_code" => 732,
                "latitude" => 24.5,
                "longitude" => -13,
                "emoji_flag" => "🇪🇭"
            ],
            [
                "name" => "Yemen",
                "code" => "YE",
                "iso3" => "YEM",
                "numeric_code" => 887,
                "latitude" => 15,
                "longitude" => 48,
                "emoji_flag" => "🇾🇪"
            ],
            [
                "name" => "Zambia",
                "code" => "ZM",
                "iso3" => "ZMB",
                "numeric_code" => 894,
                "latitude" => -15,
                "longitude" => 30,
                "emoji_flag" => "🇿🇲"
            ],
            [
                "name" => "Zimbabwe",
                "code" => "ZW",
                "iso3" => "ZWE",
                "numeric_code" => 716,
                "latitude" => -20,
                "longitude" => 30,
                "emoji_flag" => "🇿🇼"
            ],
            [
                "name" => "Åland Islands",
                "code" => "AX",
                "iso3" => "ALA",
                "numeric_code" => 248,
                "latitude" => 60.116667,
                "longitude" => 19.9,
                "emoji_flag" => "🇦🇽"
            ],
            [
                "name" => "Bonaire, Sint Eustatius and Saba",
                "code" => "BQ",
                "iso3" => "BES",
                "numeric_code" => 535,
                "latitude" => 12.183333,
                "longitude" => -68.233333,
                "emoji_flag" => "🇧🇶"
            ],
            [
                "name" => "Curaçao",
                "code" => "CW",
                "iso3" => "CUW",
                "numeric_code" => 531,
                "latitude" => 12.166667,
                "longitude" => -68.966667,
                "emoji_flag" => "🇨🇼"
            ],
            [
                "name" => "Saint Barthélemy",
                "code" => "BL",
                "iso3" => "BLM",
                "numeric_code" => 652,
                "latitude" => 17.897728,
                "longitude" => -62.834244,
                "emoji_flag" => "🇧🇱"
            ],
            [
                "name" => "Saint Martin (French part)",
                "code" => "MF",
                "iso3" => "MAF",
                "numeric_code" => 663,
                "latitude" => 18.075278,
                "longitude" => -63.06,
                "emoji_flag" => "🇲🇫"
            ],
            [
                "name" => "Sint Maarten (Dutch part)",
                "code" => "SX",
                "iso3" => "SXM",
                "numeric_code" => 534,
                "latitude" => 18.033333,
                "longitude" => -63.05,
                "emoji_flag" => "🇸🇽"
            ],
            [
                "name" => "Kosovo",
                "code" => "XK",
                "iso3" => "XKX",
                "numeric_code" => -1,
                "latitude" => 42.583333,
                "longitude" => 21,
                "emoji_flag" => "🇽🇰"
            ]
        ];

        if (Country::count() == 0) {
            foreach ($contryArr as $arr) {
                Country::create($arr);
            }
        }
    }
}
