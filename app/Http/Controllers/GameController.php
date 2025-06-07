<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    // Main Game Hub
    public function index()
    {
        return view('games.lop4.phanso.phanso');
    }

    // Base Games
    public function cakeGame()
    {
        return view('games.lop4.phanso.cake');
    }

    public function checkCakeAnswer(Request $request)
    {
        // Validate and process cake game answer
        return response()->json(['success' => true]);
    }

    public function resetCakeGame()
    {
        // Reset cake game progress
        return redirect()->back();
    }

    public function appleGame()
    {
        return view('games.lop4.phanso.apple');
    }

    public function checkAppleAnswer(Request $request)
    {
        // Validate and process apple game answer
        return response()->json(['success' => true]);
    }

    public function resetAppleGame()
    {
        // Reset apple game progress
        return redirect()->back();
    }

    public function bracketGame()
    {
        return view('games.lop4.phanso.bracket');
    }

    public function checkBracketAnswer(Request $request)
    {
        // Validate and process bracket game answer
        return response()->json(['success' => true]);
    }

    public function resetBracketGame()
    {
        // Reset bracket game progress
        return redirect()->back();
    }

    // Garden Game Methods
    public function gardenGame()
    {
        return view('games.lop4.phanso.garden');
    }

    public function checkGardenAnswer(Request $request)
    {
        // Validate and process garden game answer
        return response()->json(['success' => true]);
    }

    public function resetGardenGame()
    {
        // Reset garden game progress
        return redirect()->back();
    }

    // Tower Game Methods
    public function towerGame()
    {
        return view('games.lop4.phanso.tower');
    }

    public function checkTowerAnswer(Request $request)
    {
        // Validate and process tower game answer
        return response()->json(['success' => true]);
    }

    public function resetTowerGame()
    {
        // Reset tower game progress
        return redirect()->back();
    }

    // Cards Game Methods
    public function cardsGame()
    {
        return view('games.lop4.phanso.cards');
    }

    public function checkCardsAnswer(Request $request)
    {
        // Validate and process cards game answer
        return response()->json(['success' => true]);
    }

    public function resetCardsGame()
    {
        // Reset cards game progress
        return redirect()->back();
    }

    // Compare Game Methods
    public function compareGame()
    {
        return view('games.lop4.phanso.compare');
    }

    public function checkCompareAnswer(Request $request)
    {
        // Validate and process compare game answer
        return response()->json(['success' => true]);
    }

    public function resetCompareGame()
    {
        // Reset compare game progress
        return redirect()->back();
    }

    // Division Game Methods
    public function divisionGame()
    {
        return view('games.lop4.phanso.division');
    }

    public function checkDivisionAnswer(Request $request)
    {
        // Validate and process division game answer
        return response()->json(['success' => true]);
    }

    public function resetDivisionGame()
    {
        // Reset division game progress
        return redirect()->back();
    }

    // Fair Share Game Methods
    public function fairShareGame()
    {
        return view('games.lop4.phanso.fair_share');
    }

    public function checkFairShareAnswer(Request $request)
    {
        // Validate and process fair share game answer
        return response()->json(['success' => true]);
    }

    public function resetFairShareGame()
    {
        // Reset fair share game progress
        return redirect()->back();
    }

    // Balance Game Methods
    public function balanceGame()
    {
        return view('games.lop4.phanso.balance');
    }

    public function checkBalanceAnswer(Request $request)
    {
        // Validate and process balance game answer
        return response()->json(['success' => true]);
    }

    public function resetBalanceGame()
    {
        // Reset balance game progress
        return redirect()->back();
    }

    // Pattern Game Methods
    public function patternGame()
    {
        return view('games.lop4.phanso.pattern');
    }

    public function checkPatternAnswer(Request $request)
    {
        // Validate and process pattern game answer
        return response()->json(['success' => true]);
    }

    public function resetPatternGame()
    {
        // Reset pattern game progress
        return redirect()->back();
    }

    // Word Problem Game Methods
    public function wordProblemGame()
    {
        return view('games.lop4.phanso.word_problem');
    }

    public function checkWordProblemAnswer(Request $request)
    {
        // Validate and process word problem game answer
        return response()->json(['success' => true]);
    }

    public function resetWordProblemGame()
    {
        // Reset word problem game progress
        return redirect()->back();
    }

    // Sky Game Methods
    public function skyGame()
    {
        return view('games.lop4.phanso.sky');
    }

    public function checkSkyAnswer(Request $request)
    {
        // Validate and process sky game answer
        return response()->json(['success' => true]);
    }

    public function resetSkyGame()
    {
        // Reset sky game progress
        return redirect()->back();
    }

    // Remaining Cake Game Methods
    public function remainingCakeGame()
    {
        return view('games.lop4.phanso.remaining_cake');
    }

    public function checkRemainingCakeAnswer(Request $request)
    {
        // Validate and process remaining cake game answer
        return response()->json(['success' => true]);
    }

    public function resetRemainingCakeGame()
    {
        // Reset remaining cake game progress
        return redirect()->back();
    }

    // Sentence Game Methods
    public function sentenceGame()
    {
        return view('games.lop4.phanso.sentence');
    }

    public function checkSentenceAnswer(Request $request)
    {
        // Validate and process sentence game answer
        return response()->json(['success' => true]);
    }

    public function resetSentenceGame()
    {
        // Reset sentence game progress
        return redirect()->back();
    }
} 