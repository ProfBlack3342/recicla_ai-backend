<?php
# Para criar relatórios em PDF com PHP, você pode usar bibliotecas como FPDF ou TCPDF. Aqui está um guia passo a passo usando o FPDF:

### Usando FPDF
# 1. **Instalação**:
# - Baixe a biblioteca FPDF do site oficial: [fpdf.org](http://www.fpdf.org/).
# - Extraia o conteúdo e inclua o arquivo `fpdf.php` no seu projeto.

# 2. **Exemplo de código**:

require('_fpdf186/fpdf.php');

// Criar uma nova instância do FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Título do relatório
$pdf->Cell(0, 10, 'Relatório de Acessos', 0, 1, 'C');

// Adicionar uma linha em branco
$pdf->Ln(10);

// Definindo cabeçalhos da tabela
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Login', 1);
$pdf->Cell(40, 10, 'Nome', 1);
$pdf->Cell(40, 10, 'E-mail', 1);
$pdf->Ln();

// Adicionando dados à tabela
$pdf->SetFont('Arial', '', 12);

// Supondo que você tenha um array de dados
$acessos = [
    ['Login' => 'Teste Login 1', 'Nome' => 'Usuario 1', 'E-mail' => 'teste1@email.com'],
    ['Login' => 'Teste Login 2', 'Nome' => 'Usuario 2', 'E-mail' => 'teste2@email.com'],
];

foreach ($acessos as $acesso) {
    $pdf->Cell(40, 10, $acesso['Login'], 1);
    $pdf->Cell(40, 10, $acesso['Nome'], 1);
    $pdf->Cell(40, 10, $acesso['E-mail'], 1);
    $pdf->Ln();
}

// Salvar o PDF
$pdf->Output('D', 'relatorio_acessos.pdf'); // 'D' para download

### Considerações

# - **Estilização**: Você pode adicionar mais elementos, como imagens e gráficos, dependendo da complexidade do seu relatório.
# - **TCPDF**: Se você precisar de recursos mais avançados, como suporte a HTML, considere usar TCPDF, que oferece mais funcionalidades.
# - **Data Dinâmica**: Se você estiver usando um banco de dados, você pode integrar a consulta SQL para obter os dados dinamicamente.

### Exemplos de Recursos Adicionais

# - **Cabeçalho e Rodapé**: Você pode definir funções para criar cabeçalhos e rodapés personalizados.
# - **Formato de Página**: Personalize o tamanho da página e a orientação.
# - **Multi-Página**: Use `$pdf->AddPage()` para adicionar várias páginas ao relatório.

### Esses passos básicos devem ajudar você a começar a criar relatórios em PDF com PHP.

?>