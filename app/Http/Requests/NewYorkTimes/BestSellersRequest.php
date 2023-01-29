<?php

declare(strict_types=1);

namespace App\Http\Requests\NewYorkTimes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BestSellersRequest extends FormRequest
{
    public const ISBN = 'isbn';
    public const AUTHOR = 'author';
    public const OFFSET = 'offset';
    public const TITLE = 'title';


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
     * @return array<string, mixed>
     * @throws ValidationException
     */
    public function rules()
    {
        $parameters = $this->query->all();
        $this->checkParameters($parameters);
        $this->checkISBN($parameters);
        $this->checkOffset($parameters);


        return [
            self::ISBN => 'nullable',
            self::AUTHOR => 'nullable',
            self::OFFSET => 'nullable',
            self::TITLE => 'nullable|string',
        ];
    }

    /**
     * @throws ValidationException
     */
    private function checkParameters(array $parameters): void
    {
        if (empty($parameters)) {
            throw ValidationException::withMessages([
                'fields' => sprintf('At least one parameter is required, %s, %s, %s ,%s',
                    self::ISBN, self::AUTHOR, self::OFFSET, self::TITLE)
            ]);
        }
    }

    /**
     * @throws ValidationException
     */
    private function checkISBN(array $parameters): void
    {
        if (isset($parameters[self::ISBN])) {
            $isbn = $parameters[self::ISBN];
            if (is_string($isbn)) {
                $this->validateISBN($isbn);
            }

            if (is_array($isbn)) {
                foreach ($isbn as $isbnCode) {
                    $this->validateISBN($isbnCode);
                }
            }
        }
    }

    /**
     * @throws ValidationException
     */
    private function validateISBN(string $isbn): void
    {
        $length = strlen($isbn);

        if (10 !== $length && 13 !== $length) {
            throw ValidationException::withMessages([
                self::ISBN => 'isbn should be 10 or 13 digits.'
            ]);
        }
    }

    /**
     * @throws ValidationException
     */
    private function checkOffset(array $parameters)
    {
        if (isset($parameters[self::OFFSET])) {
            $offsetModulo = $parameters[self::OFFSET] % 20;

            if (0 !== $offsetModulo) {
                throw ValidationException::withMessages([
                    self::OFFSET => 'Offset must be a multiple of 20. Zero is a valid offset.'
                ]);
            }
        }
    }
}
