(function () {
    const code39Patterns = {
        '0': '000110100', '1': '100100001', '2': '001100001', '3': '101100000',
        '4': '000110001', '5': '100110000', '6': '001110000', '7': '000100101',
        '8': '100100100', '9': '001100100', 'A': '100001001', 'B': '001001001',
        'C': '101001000', 'D': '000011001', 'E': '100011000', 'F': '001011000',
        'G': '000001101', 'H': '100001100', 'I': '001001100', 'J': '000011100',
        'K': '100000011', 'L': '001000011', 'M': '101000010', 'N': '000010011',
        'O': '100010010', 'P': '001010010', 'Q': '000000111', 'R': '100000110',
        'S': '001000110', 'T': '000010110', 'U': '110000001', 'V': '011000001',
        'W': '111000000', 'X': '010010001', 'Y': '110010000', 'Z': '011010000',
        '-': '010000101', '.': '110000100', ' ': '011000100', '$': '010101000',
        '/': '010100010', '+': '010001010', '%': '000101010', '*': '010010100',
    };

    window.dibujarCodigoBarras = (svg, valor) => {
        svg.replaceChildren();

        if (!valor) {
            return false;
        }

        const codigo = valor.toUpperCase();
        if ([...codigo].some((caracter) => !code39Patterns[caracter] || caracter === '*')) {
            return false;
        }

        const secuencia = `*${codigo}*`;
        const altoBarras = 42;
        const altoTotal = 56;
        const zonaSilenciosa = 10;
        let anchoTotal = secuencia.length + 2 * zonaSilenciosa;
        anchoTotal += [...secuencia].reduce(
            (total, caracter) => total + [...code39Patterns[caracter]].reduce((ancho, barra) => ancho + (barra === '1' ? 3 : 1), 0),
            0
        );

        svg.setAttribute('viewBox', `0 0 ${anchoTotal} ${altoTotal}`);
        svg.setAttribute('preserveAspectRatio', 'none');

        let posicion = zonaSilenciosa;
        [...secuencia].forEach((caracter) => {
            [...code39Patterns[caracter]].forEach((barra, indice) => {
                const ancho = barra === '1' ? 3 : 1;
                if (indice % 2 === 0) {
                    const rectangulo = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
                    rectangulo.setAttribute('x', posicion);
                    rectangulo.setAttribute('y', 0);
                    rectangulo.setAttribute('width', ancho);
                    rectangulo.setAttribute('height', altoBarras);
                    rectangulo.setAttribute('fill', '#000');
                    svg.appendChild(rectangulo);
                }
                posicion += ancho;
            });
            posicion += 1;
        });

        const texto = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        texto.setAttribute('x', anchoTotal / 2);
        texto.setAttribute('y', 53);
        texto.setAttribute('text-anchor', 'middle');
        texto.setAttribute('font-size', '9');
        texto.setAttribute('font-family', 'Arial, sans-serif');
        texto.textContent = codigo;
        svg.appendChild(texto);
        return true;
    };
})();
