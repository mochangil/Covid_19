1. python 파일은 DB정보 수정후 사용하시면 됩니다(parsing_hospital.py, patient_hospital.py)
2. php 파일은 dbconfig_covid.php의 내용 수정후 사용하시면 됩니다.
3. 데이터를 insert하기전 hospital_and_patient_SQL의 SQL을 생성하고, 순서에 맞게 진행하시면 됩니다.
4. 환자간 병원 배정은 거리와는 무관하게 랜덤하게 지정하였으나
병원의 수용가능 인원수는 맞추었습니다.
5. mapsample.php에서 google api는 자신의 발급받은 api를 대입해야합니다.
6. patient.php 에서 검색기준은 병원의 ID에 따라 검색가능하게 하였고,
병원의 ID를 클릭하면 병원의 좌표상 위치를 보여줍니다.
7. indexing_SQL에 index 생성 query를 만들었습니다.


-- indexing 설명

patientinfo table을 선택하였으며, country와 province, city를 묶어 indexing 하였습니다.
환자의 지역에 따른 검색을 용이하게 하고 싶어 선정하였고, 
실제로 자신이 사는 지역의 코로나 정보를 검색할때 시,구 단위로 검색하기에 선정하였습니다.

//성능향상
country,province,city를 묶어 검색했을때(ex: Korea, Seoul, Eunpyeong-gu)
indexing 전에는 5162개의 row를 검색, 0.10의 filtered 수치를 기록했지만
indexing 후에는 46개의 row를 검색, 100의 filtered 수치를 기록했습니다.