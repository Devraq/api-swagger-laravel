<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;

use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;

class MahasiswaController extends Controller
{
	//------------------------------------------------------- Start Mahasiswa
    /**
    *    @OA\Get(
    *       path="/mahasiswa",
    *       tags={"Mahasiswa"},
    *       operationId="listNotifikasi",
    *       summary="Mahasiswa - Get All",
    *       description="Mengambil Data Mahasiswa",
	*		security={{ "bearerAuth": {} }},
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Mahasiswa",
    *               "data": {
    *                   {
	*					    "mhs_nim": "0320230010",
	*						"mhs_nama": "Eko Abdul Goffar"
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listMahasiswa() {
		$success = true;
		$message = 'Berhasil mengambil Data Mahasiswa';
		$data = Mahasiswa::All();
		
		//make response JSON
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data  
        ], 200);
    }
	
	/**
     *    @OA\Get(
     *       path="/mahasiswa/{id}",
     *       tags={"Mahasiswa"},
     *       operationId="listMahasiswaById",
     *       summary="Mahasiswa - Get By ID",
     *		security={{ "bearerAuth": {} }},
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="1",
     *       type="string",
     *     ),
     *     description="Masukan ID",
     *     example="1",
     *     in="path",
     *     name="id",
     *     required=true,
     *   ),
     *       description="Mengambil Data Mahasiswa Berdasarkan ID",
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil mengambil Data Mahasiswa ",
     *               "data": {
     *                   {
     *					    "mhs_nim": "0320230010",
	 *						"mhs_nama": "Eko Abdul Goffar"
     *					}
     *              }
     *          }),
     *      ),
     *  )
     */
    public function listMahasiswaById($id)
    {
        try {
            $success = true;
			$message = 'Berhasil mengambil Data Mahasiswa';
			$data = Mahasiswa::where('mhs_nim', $id)
                    ->get();
			
			//make response JSON
			return response()->json([
				'success' => $success,
				'message' => $message,
				'data'    => $data  
			], 200);
        } catch (QueryException $e) {
            $error = [
                'error' => $e->getMessage()
            ];
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
	
	/**
     * 	@OA\Post(
     *     	operationId="insertMahasiswa",
     *     	tags={"Mahasiswa"},
     *     	summary="Mahasiswa - Insert",
     *     	description="Post data Mahasiswa",
     *     	path="/mahasiswa/create",
     *     	security={{"bearerAuth":{}}},
     *    	@OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             example={
     *					  "mhs_nim": "0320230012",
     *					  "mhs_nama": "Roni",
     *             },
     *         ),
     *     	),
     *       @OA\Response(
     *           response="201",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *				"success": true,
     *				"message": "Data berhasil disimpan"
     *			}),
     *      ),
     * 	)
     *
     *
     */
    public function insertMahasiswa(Request $request)
    {

        //define validation rules
        $validator = Validator::make($request->all(), [
            'mhs_nim' => 'required',
            'mhs_nama' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $success = true;
		$message = 'Data berhasil disimpan';
		$result = Mahasiswa::create($request->all());
		$data = $result; 
        

        //make response JSON
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data
        ], 201);
    }
	
	/**
     * 	@OA\Put(
     *     	operationId="updateMahasiswa",
     *     	tags={"Mahasiswa"},
     *     	summary="Mahasiswa - Update",
     *     	description="Update data Mahasiswa",
     *     	path="/mahasiswa/update",
     *     	security={{"bearerAuth":{}}},
     *    	@OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             example={
     *					  "mhs_nim": "0320230012",
     *					  "mhs_nama": "Roni S"
     *             },
     *         ),
     *     	),
     *       @OA\Response(
     *           response="201",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *				"success": true,
     *				"message": "Data berhasil diubah"
     *			}),
     *      ),
     * 	)
     *
     *
     */
    public function updateMahasiswa(Request $request)
    {

        //define validation rules
        $validator = Validator::make($request->all(), [
            'mhs_nim' => 'required',
            'mhs_nama' => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $success = true;
		$message = 'Data berhasil diubah';

		$data = array(
			"mhs_nama" => $request->input("mhs_nama")
		);

		$id = $request->input("mhs_nim");
		$result = Mahasiswa::where([
			['mhs_nim', '=', $id]
		])->update($data);

        //make response JSON
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data
        ], 200);
    }
	
	/**
	* 	@OA\Delete(
	*     	operationId="deleteMahasiswa",
	*     	tags={"Mahasiswa"},
	*     	summary="Mahasiswa - Delete",
	*     	description="Delete data Mahasiswa",
	*     	path="/mahasiswa/delete",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
	*				"mhs_nim": "0320230012"
    *             },
    *         ),
    *     	),
	*       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
	*				"success": true,
	*				"message": "Data berhasil dihapus"
	*			}),
    *      ),
	 * 	)
	 *
	*
	*/
	public function deleteMahasiswa(Request $request) {
		//define validation rules
        $validator = Validator::make($request->all(), [
			  "mhs_nim"     => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
		
		$success = true;
		$message = 'Data berhasil dihapus';
		
		$id = $request->input("mhs_nim");
		$result = Mahasiswa::where([
				['mhs_nim', '=', $id]
			])->delete();
		
		//make response JSON
		return response()->json([
			'success' => $success,
			'message' => $message,
			'data'
		], 200);
    }
}
